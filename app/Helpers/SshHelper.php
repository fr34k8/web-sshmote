<?php
namespace App\Helpers;

class SshHelper {

    private $targetIp;
    private $server;
    private $command;

    public function targetIp($ip) {
        $this->targetIp = $ip;

        return $this;
    }

    public function server($server) {
        $this->server = $server;

        return $this;
    }

    public function command($command) {
        $this->command = $command;

        return $this;
    }

    public function run() {
        $connection   = null;
        $authenticate = "";

        if ($this->server->auth_method === "password") {
            $connection   = ssh2_connect($this->server->host, $this->server->port);
            $authenticate = ssh2_auth_password($connection, $this->server->username, $this->server->password);
        }

        if ($connection == null) {
            return "Cannot connect to target location: ".$this->server->name;
        }else if ($authenticate === "") {
            return "Cannot authenticate in target location: ".$this->server->name;
        }else{
            $command = $result_error = $result_io = "";

            switch($this->command) {
                case "ping":
                    $command = "ping -c 4 -t 15 ".$this->targetIp;
                    break;
                case "host":
                    $command = "host ".$this->targetIp;
                    break;
                case "traceroute":
                    $command = "traceroute -n -m 30 ".$this->targetIp;
                    break;
                default:
                    return "Cannot find related command: ".$this->command;
            }

            $stream = ssh2_exec($connection, $command);

            $streamErr = ssh2_fetch_stream($stream, SSH2_STREAM_STDERR);
            $streamIO  = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);

            stream_set_blocking($streamErr, true);
            stream_set_blocking($streamIO, true);

            $result_error = stream_get_contents($streamErr);
            $result_io    = stream_get_contents($streamIO);

            fclose($streamErr);
            fclose($streamIO);

            if (empty($result_error) === false) {
                return "Cannot execute command: ".$this->command;
            }else{
                return $result_io;
            }
        }
    }

}
