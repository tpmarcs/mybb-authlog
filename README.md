# mybb-authlog

Simple mybb plugin to log failed authentication requests.

## Compatibility

- Currently comatible and tested with mybb version 1.8.x

## Installation

- Download the `authlog.php` plugin file
- Place it under `<mybb-root>/inc/plugins`
- Install & activate the plugin via the Admin CP section `Settings --> Plugins`

## Configuration

- Navigate to `Settings --> AuthLog` in Admin CP
- Configure the log location (default is `/var/log/mybb/auth.log`)
- Configure whether authentication failures in the user cp should get logged, too

## Functionality

### Log Syntax

Log syntax is the following:
`<date> <hostname> mybb: login failure for user <username> with ip <ip> in <user cp | admin cp>`
