[![Build Status](https://travis-ci.org/zerai/albomon.svg?branch=master)](https://travis-ci.org/zerai/albomon)

# AlboMON  -  AlboPOP Monitoring application


Console application per il monitoraggio dei feed RSS prodotti dal progetto [AlboPOP](https://albopop.it).

AlboMON valuta, e restituisce in output, i seguenti parametri:

- Feed Status: 'ATTIVO/NON ATTIVO'

- Spec. Status: 'Non Rilevato'  <- valore di default la feature è da implementare

- Content Update At: data di aggiornamento feed ed il numero di giorni di ritarto esempio '2019-05-20  -53 gg.'

- Error: 'server error' se ci sono problemi rigurdanti la rete (404 500 e simili). 


## Requisiti:
- PHP >=7.1.3



## Installazione:

$ git clone https://github.com/zerai/albomon.git

$ cd albomon/

$ composer install



## Documentazione e Comandi:

#### - scansione singolo feed:
$ php bin/console albomon:check:feed <http://www.mio-feed.com/feed.xml>


#### - scansione feed da catalogo personale:
$ php bin/console albomon:check:custom-catalog


#### - scansione feed da catalogo ufficiale AlboPOP:
$ php bin/console albomon:check:albopop-catalog

[NB.] Attualmente il catalogo ufficiale gestito dall'applicazione contiene solo i primi 70 feed di [questo elenco](https://albopop.it/comune/).


#### Gestione cataloghi:

Per aggiungere o rimuovere un feed dal catalogo personale modificare il file 'catalog/custom-catalog.json'.

Per aggiungere o rimuovere un feed dal catalogo ufficiale AlboPOP modificare il file 'catalog/albopop-catalog.json'.