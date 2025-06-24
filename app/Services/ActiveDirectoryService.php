<?php
namespace App\Services;

use App\Models\Setting;

class ActiveDirectoryService
{
    protected $connection;

    public function connect(): void
    {
        $host = Setting::getValue('AD_HOST', env('AD_HOST'));
        if (!$host) {
            return;
        }
        $this->connection = @ldap_connect($host);
        if ($this->connection) {
            ldap_set_option($this->connection, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_bind(
                $this->connection,
                Setting::getValue('AD_USERNAME', env('AD_USERNAME')),
                Setting::getValue('AD_PASSWORD', env('AD_PASSWORD'))
            );
        }
    }

    public function fetchUser(string $username): array
    {
        if (!$this->connection) {
            return [];
        }
        $baseDn = Setting::getValue('AD_BASE_DN', env('AD_BASE_DN'));
        $result = ldap_search($this->connection, $baseDn, sprintf('(&(objectClass=user)(sAMAccountName=%s))', ldap_escape($username, '', LDAP_ESCAPE_FILTER)));
        $entries = ldap_get_entries($this->connection, $result);
        return $entries[0] ?? [];
    }
}

