<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\Setting;

class TestEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:email {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test email sending configuration';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing email configuration...');
        $this->newLine();
        
        // Show current mail configuration
        $this->info('Current Mail Configuration:');
        $this->line('  MAIL_MAILER: ' . config('mail.default'));
        $this->line('  MAIL_HOST: ' . config('mail.mailers.smtp.host'));
        $this->line('  MAIL_PORT: ' . config('mail.mailers.smtp.port'));
        $this->line('  MAIL_USERNAME: ' . config('mail.mailers.smtp.username'));
        $this->line('  MAIL_FROM_ADDRESS: ' . config('mail.from.address'));
        $this->line('  MAIL_FROM_NAME: ' . config('mail.from.name'));
        $this->newLine();
        
        // Get recipient email
        $recipientEmail = $this->argument('email');
        if (!$recipientEmail) {
            $settings = Setting::getGroupedSettings();
            $recipientEmail = $settings['general']['contact_email'] ?? $this->ask('Enter recipient email address');
        }
        
        if (!$recipientEmail) {
            $this->error('Email address is required');
            return 1;
        }
        
        $this->info("Sending test email to: {$recipientEmail}");
        $this->newLine();
        
        try {
            Mail::raw('This is a test email from SuperHost CMS. If you receive this, your email configuration is working correctly!', function ($message) use ($recipientEmail) {
                $message->to($recipientEmail)
                       ->subject('Test Email - SuperHost CMS');
            });
            
            $this->info('✓ Email sent successfully!');
            $this->newLine();
            $this->info('Check your inbox and spam folder.');
            
            // If using log driver, show where to find the email
            if (config('mail.default') === 'log') {
                $this->warn('Note: You are using the "log" mail driver.');
                $this->line('The email has been logged to: storage/logs/laravel.log');
                $this->line('To send real emails, change MAIL_MAILER=smtp in your .env file');
            }
            
            return 0;
            
        } catch (\Exception $e) {
            $this->error('✗ Failed to send email');
            $this->error('Error: ' . $e->getMessage());
            $this->newLine();
            $this->line('Full error details:');
            $this->line($e->getTraceAsString());
            
            return 1;
        }
    }
}
