[![Build Status](https://travis-ci.com/zerai/albomon.svg?branch=master)](https://travis-ci.com/zerai/albomon)

# AlboMON  -  AlboPOP Monitoring application


Console application per il monitoraggio dei feed RSS prodotti dal progetto [AlboPOP](https://albopop.it).


## Requisiti:
- PHP >=7.1.3



## Installazione:

$ git clone https://github.com/zerai/albomon.git

$ cd albomon/

$ composer install


## Console Command:

php bin/console albomon:check:feed <http://www.mio-feed.com/feed.xml>

php bin/console albomon:check:custom-catalog