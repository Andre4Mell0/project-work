<h1>Project-work</h1>

L'obbiettivo del project work è quello di costruire un siistema, perfettamente funzionante, che racchiuda al suo interno alcune delle principali competenze acquisite durante il corso da "Tecnico esperto in cloud computing, Solution Architecture e Cybersecurity

## Il progetto
Il pogetto consiste nel creare e documentare un architettira sistemistica, in grado di simulare un piccolo **ambiente web sicuro e monitorato**, nel dettaglio:
<ul>
  <li>ospitare una web app funzionante (anche semplice)</li>
  <li>salvare i log ed effettuarne regolarmente il backup di un bucket S3 di AWS </li>
  <li>rilevare comportamenti anomali tramite script di monitoraggio (python)</li>
  <li>generare una notifica all'utente in casoo di evento</li>
</ul>

## Specifiche 

L'ambiente comprende **due nodi**:
| Nodo | Descrizione | Funzione |
|:-----|:------------|:---------|
| WebNode (VM local) | Server Linux ospitante la WebApp | Host del servizio, generazione e monitoring dei log |
| AWS S3 Bucket | Servizio cloud esterno | Spazio di archiviazione dei log |

### WebNode
Il WebNode in questione è una macchina virtuale basata su **Ubuntu 22.04 LTS** che ospita un web server **Apache** usato per esporre una semplice pagina di log in.
I log generati automaticamente da apache vengono regolarmente analizzati per indivuduare pattern di attacco come brute force o DoS tramite uno script in python.
A intervalli regolari di tempo i log vengono automaticamente copiati su un bucket S3 dedicato.

| Servizio |  Funzione |
|---------|------------|
| Apache |  Esporre il sito  |
| PHP | Creazione delle pagine |
| MySQL | Realizzazione di un DB locale dove memorizzare le utenze |
| Python | Necessario per la realizzazione dello script |
| Fail2Ban | Per la protezione del server da attacchi |
| PhpMyAdmin | Per una più semplice interazione col DB |

Ho scelto di installare alcuni servizi inutili al fine del progetto ma che vanno a ricreare una macchina simile ad una con la quale ho lavorato in precedenza.

### Bucket S3


## Realizzazione 

### Configurare il webserver

Questa guida partirà da dopo la creazione di una installazione di Ubuntu 22.04.5 LTS reperita dalla pagina ufficiale:
https://releases.ubuntu.com/jammy/ 

#### Step 1: 

Prima di procedere all'installazione dei vari componenti dobbiamo essere sicuri che tutti i pacchetti siano aggiornati
```
sudo apt update
sudo apt upgrade
```

### Step 2:

Per esporre la nostra pagina web dovremo installare e abilitare **Apache HTTP Server** 

```
sudo apt install apache2
sudo systemctl enable apache2
sudo systemctl start apache2
```
successivamente abilitiamo Apache nel firewall 

```
sudo ufw enable
sudo ufw allow 'Apache Full'
sudo ufu reload 
```
per controllare che l'operazione sia avvenuta con successo possuamo usare il seguente comando
```
sudo ufu app list
```
```
Output:

Available applications:
  Apache
  Apache Full
  Apache Secure
  OpenSSH
```

a questo punto la nostra pagina dovrebbe essere raggiungibile dai dispositivi collegati nella nostra rete locale tramite indirizzo ip
```
http://<ip della vm>
```
**NOTA**: per essere raggiungibile in questo modo la cheda di rete della VM dovrà essere impostata in **bridge**, altrivemti dovremo configurare il port forwarding tramite Virtual Box 


# Step 3: 

adesso dobbiamo installare MySQL, dove andremo a memorizzare i dati tra cui le credenziali dei nostri utenti

```
sudo apt install mysql-server
```
```
sudo mysql_secure_installation
```
A seconda delle nostre preferenze scegliere tra le opzioni y/n

Suuccessivamente dovremo andare a creare il database e la tabella delle utenze che creeremo manualmente per semplicità.

**NOTA**: visto che le password non devono essere mai salvate in chiaro andremo ad inserire l'hash delle password
