# mybb-authlog

Simple mybb plugin to log failed authentication requests.

## Compatibility

- Currently compatible and tested with mybb version 1.8.x

## Installation

- Download the `authlog.php` plugin file
- Place it under `<mybb-root>/inc/plugins/`
- Install & activate the plugin via the Admin CP section `Settings --> Plugins`

## Configuration

- Navigate to `Settings --> AuthLog` in Admin CP
- Configure the log location (default is `/var/log/mybb/auth.log`)
- Configure whether authentication failures in the User CP should get logged, too

## Functionality

### Log Syntax

Log syntax is the following:

`<date> <hostname> mybb: login failure for user <username> with ip <ip> in <user cp | admin cp>`

### Fail2Ban

Additionaly you can configure a fail2ban filter to block malicious clients based on there ips by downloading and installing `mybb.conf` to `/etc/fail2ban/filter.d/`. Afterwards you need to adjust `/etc/fail2ban/jail.local` to include the given filter with parameters that fit you needs.

Finally restart fail2ban to go live with your configuration: 

`service fail2ban restart`
