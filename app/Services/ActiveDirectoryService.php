<?php
namespace App\Services;

class ActiveDirectoryService
{
    protected $connection;

    public function connect(): void
    {
        $host = env('AD_HOST');
        if (!$host) {
            return;
        }
        $this->connection = @ldap_connect($host);
        if ($this->connection) {
            ldap_set_option($this->connection, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_bind($this->connection, env('AD_USERNAME'), env('AD_PASSWORD'));
        }
    }

    public function fetchUser(string $username): array
    {
        if (!$this->connection) {
            return [];
        }
        $baseDn = env('AD_BASE_DN');
        $result = ldap_search($this->connection, $baseDn, sprintf('(&(objectClass=user)(sAMAccountName=%s))', ldap_escape($username, '', LDAP_ESCAPE_FILTER)));
        $entries = ldap_get_entries($this->connection, $result);
        return $entries[0] ?? [];
    }
}

