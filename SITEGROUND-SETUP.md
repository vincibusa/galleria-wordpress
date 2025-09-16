# Configurazione Tema Galleria su SiteGround

## Problemi Risolti
Questo tema è stato ottimizzato per risolvere i problemi di pagine bianche nell'admin dashboard su hosting SiteGround.

## Modifiche Implementate

### 1. Configurazioni wp-config.php
- **Memory Limit**: Aumentato a 512M per gestire la complessità del tema
- **Execution Time**: Esteso a 300 secondi per operazioni complesse
- **Cache**: Abilitato per migliorare le performance
- **Ottimizzazioni Database**: Ridotte revisioni e autosave

### 2. Ottimizzazioni functions.php
- **Error Handler**: Gestione migliorata degli errori PHP
- **Lazy Loading**: Caricamento condizionale delle funzioni admin
- **Cache Functions**: Funzioni per ottimizzare le query ripetitive
- **Memory Management**: Controllo uso memoria in tempo reale

### 3. Nuovo File hosting-optimization.php
- **Classe Ottimizzatore**: Gestione automatica delle ottimizzazioni
- **Controllo Memory**: Monitoraggio uso memoria e garbage collection
- **Admin Optimizations**: Riduzione carico nelle pagine admin
- **Error Handling**: Gestione errori fatali con messaggi user-friendly

### 4. File .htaccess Ottimizzato
- **Limiti PHP**: Configurazioni server-side per SiteGround
- **Compressione GZIP**: Riduzione banda utilizzata
- **Cache Headers**: Ottimizzazione caricamento risorse
- **Sicurezza**: Protezione file sensibili

## Istruzioni per il Deploy su SiteGround

### Prima del Caricamento
1. **Backup**: Fai sempre backup del sito esistente
2. **Test Locale**: Verifica che tutte le ottimizzazioni funzionino in locale
3. **Plugin**: Lista tutti i plugin attivi per verificare compatibilità

### Durante il Caricamento
1. **FTP/File Manager**: Carica tutti i file del tema
2. **wp-config.php**: Sostituisci con la versione ottimizzata (IMPORTANTE: mantieni le credenziali DB corrette)
3. **.htaccess**: Verifica che le regole siano state applicate
4. **Permessi**: Assicurati che i permessi file siano corretti (644 per file, 755 per cartelle)

### Dopo il Caricamento
1. **Test Admin**: Verifica che l'admin dashboard carichi correttamente
2. **Performance**: Controlla i tempi di caricamento
3. **Error Logs**: Monitora eventuali errori nei log del server
4. **Plugin**: Riattiva i plugin uno per uno per verificare compatibilità

## Configurazioni Consigliate SiteGround

### Nel Pannello SiteGround
1. **PHP Version**: Usa PHP 8.1 o superiore
2. **SuperCacher**: Attiva il caching dinamico
3. **SG Optimizer**: Configura le ottimizzazioni automatiche
4. **Memory Limit**: Verifica sia impostato ad almeno 512M

### Impostazioni PHP Raccomandate
```ini
memory_limit = 512M
max_execution_time = 300
max_input_time = 300
upload_max_filesize = 64M
post_max_size = 64M
```

## Monitoraggio e Manutenzione

### Log da Controllare
- `/error_log` nella root del sito
- Log di WordPress in `/wp-content/debug.log`
- Log del tema per errori specifici

### Performance da Verificare
- Tempo caricamento admin dashboard (< 3 secondi)
- Uso memoria PHP (< 80% del limite)
- Tempo risposta query database (< 1 secondo)

### Manutenzione Periodica
- Pulizia cache ogni settimana
- Controllo log errori settimanalmente
- Aggiornamento ottimizzazioni se necessario

## Troubleshooting

### Se Persistono Pagine Bianche
1. **Attiva Debug**: Decommenta le righe debug nel wp-config.php
2. **Controlla Log**: Cerca errori specifici nei file di log
3. **Incrementa Memory**: Prova ad aumentare a 768M se necessario
4. **Plugin Conflict**: Disattiva tutti i plugin e riattivali uno per uno

### Errori Comuni SiteGround
- **504 Gateway Timeout**: Aumenta max_execution_time
- **503 Service Unavailable**: Riduci carico server, verifica CPU limits
- **Fatal Error Memory**: Aumenta memory_limit nel wp-config.php

### Contatti Support
- **SiteGround**: Per limiti hosting e configurazioni server
- **Developer**: Per ottimizzazioni tema specifiche

## Note Importanti
- ⚠️ NON rimuovere le ottimizzazioni senza prima testare
- ✅ Mantieni sempre backup aggiornati
- 🔍 Monitora performance regolarmente
- 🆙 Aggiorna le ottimizzazioni con nuove versioni WordPress

---
*Ottimizzazioni create specificamente per hosting SiteGround - Gennaio 2025*