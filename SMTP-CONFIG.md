# 📧 Configurazione SMTP per Galleria Catanzaro

Il tema ha integrato un sistema SMTP personalizzato per garantire l'invio affidabile delle email del form di contatto senza dipendere da plugin.

## 🚀 Setup Rapido

### 1. Configura Gmail App Password

1. **Vai su [myaccount.google.com](https://myaccount.google.com)**
2. **Security** nel menu a sinistra
3. **Attiva "2-Step Verification"** (se non già attivata)
4. **Vai su "App passwords"**
5. **Seleziona:**
   - App: "Mail" 
   - Device: "Other (custom name)" → "WordPress SMTP"
6. **Clicca "Generate"**
7. **Copia la password** generata (16 caratteri tipo: `abcd efgh ijkl mnop`)

### 2. Aggiungi Costanti al wp-config.php

Apri il file `wp-config.php` e aggiungi queste righe **PRIMA** della riga `/* That's all, stop editing! */`:

```php
// SMTP Configuration for Galleria Catanzaro
define('GALLERIA_SMTP_HOST', 'smtp.gmail.com');
define('GALLERIA_SMTP_PORT', 587);
define('GALLERIA_SMTP_SECURE', 'tls');
define('GALLERIA_SMTP_USER', 'tua-email@gmail.com');           // ← Sostituisci con la tua email Gmail
define('GALLERIA_SMTP_PASS', 'tua-app-password');              // ← Sostituisci con App Password
define('GALLERIA_SMTP_FROM', 'tua-email@gmail.com');           // ← Email mittente
define('GALLERIA_SMTP_FROM_NAME', 'Galleria Adalberto Catanzaro');

// Opzionale: Abilita debug SMTP (solo per troubleshooting)
// define('GALLERIA_SMTP_DEBUG', true);
```

### 3. Testa la Configurazione

1. **Vai nell'admin WordPress**
2. **Vedrai un link "Test SMTP"** nella barra superiore
3. **Clicca per inviare email di test**
4. **Controlla la tua casella Gmail**

## 🔧 Configurazioni Alternative

### Per Altri Provider Email

#### **Outlook/Hotmail:**
```php
define('GALLERIA_SMTP_HOST', 'smtp-mail.outlook.com');
define('GALLERIA_SMTP_PORT', 587);
define('GALLERIA_SMTP_SECURE', 'tls');
```

#### **Yahoo:**
```php
define('GALLERIA_SMTP_HOST', 'smtp.mail.yahoo.com');
define('GALLERIA_SMTP_PORT', 587);
define('GALLERIA_SMTP_SECURE', 'tls');
```

#### **Provider Personalizzato:**
```php
define('GALLERIA_SMTP_HOST', 'mail.tuodominio.com');
define('GALLERIA_SMTP_PORT', 587);  // o 465 per SSL
define('GALLERIA_SMTP_SECURE', 'tls'); // o 'ssl'
```

## 🛠 Troubleshooting

### Se le Email Non Arrivano:

1. **Abilita Debug:**
   ```php
   define('GALLERIA_SMTP_DEBUG', true);
   ```

2. **Controlla i Log:**
   - Vai su **Strumenti → Salute del sito → Info**
   - Oppure controlla `/wp-content/debug.log`

3. **Verifica Credenziali:**
   - App Password corretta (non password normale)
   - Email Gmail corretta
   - 2-Step Verification attivata

4. **Testa Manualmente:**
   - Clicca "Test SMTP" nell'admin
   - Compila il form di contatto

### Errori Comuni:

- **"Authentication failed"** → Controlla App Password
- **"Connection refused"** → Verifica host e porta
- **"SSL/TLS error"** → Prova con port 465 e 'ssl'

## 📋 Funzionalità Incluse

- ✅ **Configurazione SMTP** via constanti sicure
- ✅ **Test email** integrato nell'admin
- ✅ **Debug e logging** degli errori
- ✅ **Fallback** alla funzione mail() standard
- ✅ **Compatibilità** con tutti i form WordPress
- ✅ **Sicurezza** - nessuna password hardcoded
- ✅ **Admin notices** per status e errori

## 📬 Come Funziona

1. **Form di contatto** usa `wp_mail()`
2. **Sistema SMTP** intercetta e invia via Gmail
3. **Email arriva** nella tua casella Gmail
4. **Log automatico** di eventuali errori

Il form di contatto esistente continuerà a funzionare esattamente come prima, ma ora con consegna garantita! 🎉