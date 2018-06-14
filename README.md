# mybb-login-log

Simple mybb plugin to log successful authentication requests.

## Compatibility

- Currently compatible and tested with mybb version 1.8.x

## Installation

- Download the `loginlog.php` plugin file
- Place it under `<mybb-root>/inc/plugins/`
- Install & activate the plugin via the Admin CP section `Settings --> Plugins`

## Configuration

- Navigate to `Settings --> AuthLog` in Admin CP
- Configure the log location (default is `/var/log/mybb/loginlog.log`)
- Configure whether authentication success in the User CP should get logged, too

## Functionality

### Log Syntax

Log syntax is the following:

`<date> <hostname> mybb: login for user <username> with ip <ip> in <user cp | admin cp>`