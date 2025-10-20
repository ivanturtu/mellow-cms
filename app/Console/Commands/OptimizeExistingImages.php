<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ImageOptimizationService;
use App\Models\Slider;
use App\Models\Room;
use App\Models\Gallery;
use App\Models\Service;
use App\Models\Blog;
use App\Models\AboutSection;
use Illuminate\Support\Facades\Storage;

class OptimizeExistingImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:optimize {--model=all : Model to optimize (sliders, rooms, gallery, services, blogs, about, all)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Optimize existing images to WebP format';

    protected $imageService;

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
        $this->imageService = new ImageOptimizationService();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $model = $this->option('model');
        
        $this->info('Starting image optimization...');
        
        switch ($model) {
            case 'sliders':
                $this->optimizeSliders();
                break;
            case 'rooms':
                $this->optimizeRooms();
                break;
            case 'gallery':
                $this->optimizeGallery();
                break;
            case 'services':
                $this->optimizeServices();
                break;
            case 'blogs':
                $this->optimizeBlogs();
                break;
            case 'about':
                $this->optimizeAbout();
                break;
            case 'all':
            default:
                $this->optimizeSliders();
                $this->optimizeRooms();
                $this->optimizeGallery();
                $this->optimizeServices();
                $this->optimizeBlogs();
                $this->optimizeAbout();
                break;
        }
        
        $this->info('Image optimization completed!');
    }

    protected function optimizeSliders()
    {
        $this->info('Optimizing slider images...');
        
        $sliders = Slider::whereNotNull('image')->get();
        $bar = $this->output->createProgressBar($sliders->count());
        
        foreach ($sliders as $slider) {
            if (Storage::disk('public')->exists($slider->image)) {
                try {
                    $processedImages = $this->imageService->optimizeExistingImage($slider->image, [
                        'original' => null,
                        'xl' => [1920, 1080],
                        'lg' => [1200, 800],
                        'md' => [800, 600],
                        'sm' => [600, 400],
                        'xs' => [400, 300]
                    ], 85);
                    
                    $slider->update([
                        'image' => $processedImages['md']['path'],
                        'image_sizes' => $processedImages
                    ]);
                    
                    $this->line(" ✓ Optimized slider: {$slider->title}");
                } catch (\Exception $e) {
                    $this->error(" ✗ Failed to optimize slider {$slider->title}: " . $e->getMessage());
                }
            }
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine();
    }

    protected function optimizeRooms()
    {
        $this->info('Optimizing room images...');
        
        $rooms = Room::whereNotNull('image')->get();
        $bar = $this->output->createProgressBar($rooms->count());
        
        foreach ($rooms as $room) {
            if (Storage::disk('public')->exists($room->image)) {
                try {
                    $processedImages = $this->imageService->optimizeExistingImage($room->image, [
                        'original' => null,
                        'lg' => [1200, 800],
                        'md' => [800, 600],
                        'sm' => [600, 400]
                    ], 85);
                    
                    $room->update([
                        'image' => $processedImages['md']['path'],
                        'image_sizes' => $processedImages
                    ]);
                    
                    $this->line(" ✓ Optimized room: {$room->name}");
                } catch (\Exception $e) {
                    $this->error(" ✗ Failed to optimize room {$room->name}: " . $e->getMessage());
                }
            }
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine();
    }

    protected function optimizeGallery()
    {
        $this->info('Optimizing gallery images...');
        
        $gallery = Gallery::whereNotNull('image')->get();
        $bar = $this->output->createProgressBar($gallery->count());
        
        foreach ($gallery as $item) {
            if (Storage::disk('public')->exists($item->image)) {
                try {
                    $processedImages = $this->imageService->optimizeExistingImage($item->image, [
                        'original' => null,
                        'lg' => [1200, 800],
                        'md' => [800, 600],
                        'sm' => [600, 400]
                    ], 85);
                    
                    $item->update([
                        'image' => $processedImages['md']['path'],
                        'image_sizes' => $processedImages
                    ]);
                    
                    $this->line(" ✓ Optimized gallery item: {$item->title}");
                } catch (\Exception $e) {
                    $this->error(" ✗ Failed to optimize gallery item {$item->title}: " . $e->getMessage());
                }
            }
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine();
    }

    protected function optimizeServices()
    {
        $this->info('Optimizing service images...');
        
        $services = Service::whereNotNull('image')->get();
        $bar = $this->output->createProgressBar($services->count());
        
        foreach ($services as $service) {
            if (Storage::disk('public')->exists($service->image)) {
                try {
                    $processedImages = $this->imageService->optimizeExistingImage($service->image, [
                        'original' => null,
                        'lg' => [1200, 800],
                        'md' => [800, 600],
                        'sm' => [600, 400]
                    ], 85);
                    
                    $service->update([
                        'image' => $processedImages['md']['path'],
                        'image_sizes' => $processedImages
                    ]);
                    
                    $this->line(" ✓ Optimized service: {$service->name}");
                } catch (\Exception $e) {
                    $this->error(" ✗ Failed to optimize service {$service->name}: " . $e->getMessage());
                }
            }
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine();
    }

    protected function optimizeBlogs()
    {
        $this->info('Optimizing blog images...');
        
        $blogs = Blog::whereNotNull('image')->get();
        $bar = $this->output->createProgressBar($blogs->count());
        
        foreach ($blogs as $blog) {
            if (Storage::disk('public')->exists($blog->image)) {
                try {
                    $processedImages = $this->imageService->optimizeExistingImage($blog->image, [
                        'original' => null,
                        'lg' => [1200, 800],
                        'md' => [800, 600],
                        'sm' => [600, 400]
                    ], 85);
                    
                    $blog->update([
                        'image' => $processedImages['md']['path'],
                        'image_sizes' => $processedImages
                    ]);
                    
                    $this->line(" ✓ Optimized blog: {$blog->title}");
                } catch (\Exception $e) {
                    $this->error(" ✗ Failed to optimize blog {$blog->title}: " . $e->getMessage());
                }
            }
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine();
    }

    protected function optimizeAbout()
    {
        $this->info('Optimizing about section images...');
        
        $aboutSections = AboutSection::all();
        $bar = $this->output->createProgressBar($aboutSections->count());
        
        foreach ($aboutSections as $about) {
            $images = ['image_1', 'image_2', 'image_3'];
            $imageSizes = ['image_1_sizes', 'image_2_sizes', 'image_3_sizes'];
            
            $updateData = [];
            
            foreach ($images as $index => $imageField) {
                if ($about->$imageField && Storage::disk('public')->exists($about->$imageField)) {
                    try {
                        $processedImages = $this->imageService->optimizeExistingImage($about->$imageField, [
                            'original' => null,
                            'lg' => [1200, 800],
                            'md' => [800, 600],
                            'sm' => [600, 400]
                        ], 85);
                        
                        $updateData[$imageField] = $processedImages['md']['path'];
                        $updateData[$imageSizes[$index]] = $processedImages;
                        
                        $this->line(" ✓ Optimized about image {$imageField}: {$about->title}");
                    } catch (\Exception $e) {
                        $this->error(" ✗ Failed to optimize about image {$imageField} for {$about->title}: " . $e->getMessage());
                    }
                }
            }
            
            if (!empty($updateData)) {
                $about->update($updateData);
            }
            
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine();
    }
}