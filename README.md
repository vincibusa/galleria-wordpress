# Galleria Adalberto Catanzaro - WordPress Theme

Tema WordPress personalizzato per la Galleria Adalberto Catanzaro, sincronizzato con il sito Next.js originale.

## Caratteristiche

### Custom Post Types
- **Artisti** (`artist`): Gestione degli artisti con biografia e metadati
- **Mostre** (`exhibition`): Gestione delle mostre con date, curatori, sedi
- **Pubblicazioni** (`publication`): Gestione delle pubblicazioni (futuro uso)

### Tassonomie Personalizzate
- **Status Mostra** (`exhibition_status`): current, past, upcoming
- **Sedi** (`location`): palermo, bagheria, spoleto

### Template Files
- `front-page.php`: Homepage con carousel mostre e sezione news
- `page-about.php`: Pagina about con informazioni complete della galleria
- `page-contact.php`: Pagina contatti con form
- `archive-artist.php`: Archivio artisti
- `archive-exhibition.php`: Archivio mostre
- `single-artist.php`: Pagina singolo artista
- `single-exhibition.php`: Pagina singola mostra

### ACF Integration
Il tema utilizza Advanced Custom Fields per:
- Campi artista (biografia, anno di nascita, nazionalità, sito web)
- Campi mostra (artista, curatore, sede, date, featured)
- Campi pubblicazione (autore, ISBN, anno, prezzo, link acquisto)
- Opzioni homepage e galleria

### Struttura Asset
```
assets/
├── css/           # Fogli di stile personalizzati
├── js/            # JavaScript del tema
└── images/        # Immagini migrate dal sito Next.js
    ├── FOTO ELENCHI/  # Immagini delle mostre
    ├── about.jpeg
    ├── hero1.jpg
    ├── logo.png
    ├── news1.jpeg
    ├── news2.jpeg
    ├── news3.jpeg
    └── opera1.jpeg
```

## Installazione

1. Copia il tema nella cartella `/wp-content/themes/`
2. Attiva il tema dal dashboard WordPress
3. Installa e attiva Advanced Custom Fields Pro
4. Esegui lo script di migrazione (vedi `MIGRATION_INSTRUCTIONS.md`)

## Migrazione dal Next.js

Il tema include uno script di migrazione completo (`migration-script.php`) che:
- Importa tutti e 15 gli artisti
- Importa tutte le 19 mostre storiche
- Importa le 3 news attuali
- Crea le pagine About e Contact con contenuto completo
- Configura tutte le tassonomie e metadati

## Funzionalità Homepage

### Carousel Mostre in Evidenza
- Auto-play con controlli manuali
- Supporto touch per mobile
- Mostre marcate come "featured" appaiono automaticamente

### Sezione News & Events
- Grid responsive a 3 colonne
- Categorie automatiche (Solo Exhibition, Group Exhibition, News)
- Link "Vedi di più" quando ci sono più di 6 articoli

## Compatibilità
- WordPress 5.0+
- PHP 7.4+
- ACF Pro 5.8+

## SEO e Struttura
- Schema.org markup per Art Gallery
- Meta tags ottimizzati per social sharing
- URL SEO-friendly
- Structured data per mostre e artisti

## Responsive Design
- Mobile-first approach
- Breakpoints: 768px, 1024px
- Touch-friendly navigation
- Ottimizzazione immagini automatica

## Support
Per problemi tecnici o domande:
1. Verifica la documentazione in `MIGRATION_INSTRUCTIONS.md`
2. Controlla i log di WordPress per errori
3. Testa con debug WordPress attivato# galleria-wordpress
