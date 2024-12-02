<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        // $this->migrator->add('mail.from_address', 'no-reply@bwc.dole.gov.ph');
        // $this->migrator->add('mail.from_name', 'DOLE Bureau of Working Conditions');
        // $this->migrator->add('mail.driver', 'smtp');
        // $this->migrator->add('mail.host', 'sandbox.smtp.mailtrap.io');
        // $this->migrator->add('mail.port', '2525');
        // $this->migrator->add('mail.encryption', 'TLS');
        // $this->migrator->addEncrypted('mail.username', '7722f715ff117f');
        // $this->migrator->addEncrypted('mail.password', 'b7f09ec290fccf');
        // $this->migrator->add('mail.timeout', null);
        // $this->migrator->add('mail.local_domain', null);
        
        $this->migrator->add('mail.from_address', 'ocp@bwc-staging.com');
        $this->migrator->add('mail.from_name', 'Online Compliance Portal');
        $this->migrator->add('mail.driver', 'smtp');
        $this->migrator->add('mail.host', 'smtp.hostinger.com');
        $this->migrator->add('mail.port', '465');
        $this->migrator->add('mail.encryption', 'SSL');
        $this->migrator->addEncrypted('mail.username', 'ocp@bwc-staging.com');
        $this->migrator->addEncrypted('mail.password', '@Bwc_justnoone14@');
        $this->migrator->add('mail.timeout', null);
        $this->migrator->add('mail.local_domain', null);
    }
};
