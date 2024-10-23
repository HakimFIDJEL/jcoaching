<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';

    protected $description = 'Generate the sitemap for the website';

    public function handle()
    {
        Sitemap::create()
            ->add(Url::create('/')->setPriority(1.0)->setChangeFrequency('weekly'))
            ->add(Url::create('/auth/login')->setPriority(0.8)->setChangeFrequency('monthly'))
            ->add(Url::create('/auth/register')->setPriority(0.8)->setChangeFrequency('monthly'))
            ->add(Url::create('/about')->setPriority(0.7)->setChangeFrequency('monthly'))
            ->add(Url::create('/pricings')->setPriority(0.6)->setChangeFrequency('monthly'))
            ->add(Url::create('/contact')->setPriority(0.5)->setChangeFrequency('monthly'))
            ->add(Url::create('/galerie')->setPriority(0.5)->setChangeFrequency('monthly'))
            ->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully.');
    }
}
