<?php

namespace App\Filament\Pages;

use App\Helpers\SettingHelper;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Exceptions\Halt;
use Illuminate\Support\Facades\Storage;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;

class Seo extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';

    protected static string $view = 'filament.pages.seo';

    protected static ?string $title = 'SEO Settings';

    protected static ?string $navigationLabel = 'SEO';

    protected static ?int $navigationSort = 97;

    protected static ?string $navigationGroup = 'Trang web';

    public ?array $data = [];

    public function mount(): void
    {
        try {
            $settings = SettingHelper::all();
            $this->form->fill([
                'seo_title' => $settings['seo_title'] ?? '',
                'seo_image' => $settings['seo_image'] ?? '',
                'seo_description' => $settings['seo_description'] ?? '',
                'seo_keywords' => $settings['seo_keywords'] ?? '',
                'sitemap_file' => $settings['sitemap_file'] ?? null,
                'ga_head' => $settings['ga_head'] ?? '',
                'ga_body' => $settings['ga_body'] ?? '',
            ]);
        } catch (\Exception $e) {
            // Fallback nếu có lỗi
            $this->form->fill([
                'seo_title' => '',
                'seo_image' => '',
                'seo_description' => '',
                'seo_keywords' => '',
                'sitemap_file' => null,
                'ga_head' => '',
                'ga_body' => '',
            ]);
        }
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Meta Tags')
                    ->description('Cài đặt các thẻ meta cho trang web của bạn')
                    ->schema([
                        FileUpload::make('seo_image')
                            ->label('Meta Image')
                            ->image()
                            ->directory('seo-images')
                            ->visibility('public')
                            ->imageEditor()
                            ->acceptedFileTypes(['image/*'])
                            ->required()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->helperText('Ảnh đại diện khi chia sẻ lên mạng xã hội. Kích thước đề xuất: 1200x630px'),

                        TextInput::make('seo_title')
                            ->label('Meta Title')
                            ->helperText('Tiêu đề hiển thị trên kết quả tìm kiếm Google')
                            ->maxLength(100),

                        Textarea::make('seo_description')
                            ->label('Meta Description')
                            ->helperText('Mô tả hiển thị trên kết quả tìm kiếm Google')
                            ->maxLength(300)
                            ->rows(2),

                        Textarea::make('seo_keywords')
                            ->label('Meta Keywords')
                            ->helperText('Từ khóa liên quan đến nội dung trang web, phân cách bằng dấu phẩy')
                            ->maxLength(300)
                            ->rows(2),
                    ]),

                Section::make('Sitemap')
                    ->description('Quản lý file sitemap.xml cho trang web')
                    ->schema([
                        Placeholder::make('sitemap_info')
                            ->label('Thông tin về Sitemap')
                            ->content(view('filament.components.sitemap-info')),

                        FileUpload::make('sitemap_file')
                            ->label('Upload Sitemap File')
                            ->acceptedFileTypes(['application/xml', 'text/xml'])
                            ->maxSize(5120) // 5MB
                            ->disk('public')
                            ->helperText('Chỉ chấp nhận file .xml, tối đa 5MB.'),
                    ]),

                Section::make('Google Analytics')
                    ->description('Thêm mã Google Analytics vào trang web của bạn')
                    ->schema([
                        Textarea::make('ga_head')
                            ->label('GA Code in <head>')
                            ->helperText("Thêm mã Google Analytics vào thẻ <head> của trang web. Bạn có thể lấy mã này từ trang quản trị Google Analytics của bạn.")
                            ->placeholder("<script async src='https://www.googletagmanager.com/gtag/js?id=G-XXXXXXXXXX'></script>")
                            ->rows(2)
                            ->maxLength(2000),

                        Textarea::make('ga_body')
                            ->label('GA Code after <body>')
                            ->helperText('Thêm mã Google Analytics ngay sau thẻ <body> của trang web. Bạn có thể lấy mã này từ trang quản trị Google Analytics của bạn.')
                            ->placeholder("<script>\n  window.dataLayer = window.dataLayer || [];\n  function gtag(){dataLayer.push(arguments);}\n  gtag('js', new Date());\n\n  gtag('config', 'G-XXXXXXXXXX');\n</script>")
                            ->rows(6)
                            ->maxLength(2000),
                    ]),

            ])
            ->statePath('data');
    }

    public function save(): void
    {
        try {
            $data = $this->form->getState();
            SettingHelper::clearCache();
            foreach ($data as $key => $value) {
                SettingHelper::set($key, $value);
            }

            // thao tác với file sitemap nếu có
            if (!empty($data['sitemap_file'])) {
                $sitemapPath = $data['sitemap_file'];

                // sao chép file đã tải lên vào thư mục public với tên sitemap.xml
                $content = Storage::disk('public')->get($sitemapPath);
                file_put_contents(public_path('sitemap.xml'), $content);

                // Xóa file tạm đã tải lên
                Storage::disk('public')->delete($sitemapPath);

                Notification::make()
                    ->title('Sitemap đã được cập nhật thành công!')
                    ->body('File sitemap.xml đã được upload và có thể truy cập tại: ' . url('/sitemap.xml'))
                    ->success()
                    ->send();
            } else {
                Notification::make()
                    ->title('Cài đặt SEO đã được lưu thành công!')
                    ->success()
                    ->send();
            }
            SettingHelper::clearCache();
        } catch (Halt $exception) {
            return;
        }
    }

    protected function getFormActions(): array
    {
        return [
            Forms\Components\Actions\Action::make('save')
                ->label('Lưu cài đặt')
                ->action('save'),
        ];
    }
}
