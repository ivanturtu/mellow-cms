# Debug Guide: Drag & Drop Image Upload

## Come fare debug del drag & drop

### 1. Apri la Console del Browser
- **Chrome/Edge**: `F12` o `Ctrl+Shift+I` (Windows) / `Cmd+Option+I` (Mac)
- **Firefox**: `F12` o `Ctrl+Shift+K` (Windows) / `Cmd+Option+K` (Mac)
- **Safari**: Abilita "Sviluppatore" nelle preferenze, poi `Cmd+Option+C`

### 2. Filtra i Log di Debug
Nella console, cerca i messaggi che iniziano con `[ImageUpload Debug]`

### 3. Test del Drag & Drop

#### Passo 1: Apri il Modal
1. Vai in Admin → Blog (o Slider/Gallery/Service)
2. Clicca su "Crea Nuovo" o "Modifica"
3. Clicca sul pulsante "Carica con Drag & Drop"
4. **Controlla la console** - dovresti vedere:
   ```
   [ImageUpload Debug] Component ID: [un-id-univoco]
   [ImageUpload Debug] Input ID: image-input-[un-id-univoco]
   [ImageUpload Debug] Drop zone found: true
   [ImageUpload Debug] Input element found: true
   [ImageUpload Debug] Drag & drop initialized successfully
   ```

#### Passo 2: Prova il Drag & Drop
1. Trascina un'immagine sulla zona di drop
2. **Controlla la console** - dovresti vedere:
   ```
   [ImageUpload Debug] Event: dragenter
   [ImageUpload Debug] Drop zone highlighted
   [ImageUpload Debug] Event: dragover
   [ImageUpload Debug] Event: drop
   [ImageUpload Debug] Drop event triggered
   [ImageUpload Debug] Files dropped: 1
   [ImageUpload Debug] File 0: {name: "...", type: "image/jpeg", size: ...}
   [ImageUpload Debug] Files assigned to input, triggering change event
   [ImageUpload Debug] Events dispatched, waiting for Livewire...
   ```

### 4. Problemi Comuni e Soluzioni

#### Problema: "Drop zone not found"
**Causa**: Il componente non è ancora stato renderizzato nel DOM
**Soluzione**: Lo script riprova automaticamente ogni 100ms. Se persiste:
- Verifica che il modal sia aperto
- Controlla che il componente Livewire sia caricato correttamente

#### Problema: "Input element not found"
**Causa**: L'input file non è stato creato correttamente
**Soluzione**: 
- Verifica che Livewire sia caricato
- Controlla che non ci siano errori JavaScript nella console
- Ricarica la pagina

#### Problema: I file vengono droppati ma non si caricano
**Causa**: Livewire non rileva il cambio dell'input
**Soluzione**:
- Verifica nella console che gli eventi `change` e `input` vengano dispatchati
- Controlla la Network tab per vedere se viene fatta una richiesta al server
- Verifica i permessi di scrittura sulla cartella `storage/app/public`

#### Problema: "Livewire not detected"
**Causa**: Livewire non è caricato o non è disponibile
**Soluzione**:
- Verifica che Livewire sia incluso nella pagina
- Controlla che non ci siano conflitti con altre librerie JavaScript

### 5. Verifica dei Permessi

Assicurati che le cartelle di storage abbiano i permessi corretti:

```bash
# In produzione
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Verifica che il symlink esista
php artisan storage:link
```

### 6. Verifica della Configurazione Livewire

Controlla che Livewire sia configurato correttamente per l'upload:

```php
// config/livewire.php
'temporary_file_upload' => [
    'disk' => 'local',
    'rules' => ['required', 'image', 'max:2048'],
    'directory' => 'livewire-tmp',
    'middleware' => null,
    'preview_mimes' => ['png', 'gif', 'bmp', 'svg', 'wav', 'mp4', 'mov', 'avi', 'wmv', 'mp3', 'm4a', 'jpg', 'jpeg'],
    'max_upload_timeout_seconds' => 5 * 60,
],
```

### 7. Test Manuale Alternativo

Se il drag & drop non funziona, puoi testare l'upload normale:
1. Clicca sulla zona di drop (dovrebbe aprire il file picker)
2. Seleziona un'immagine
3. Verifica che venga caricata

Se questo funziona ma il drag & drop no, il problema è nello script JavaScript.

### 8. Log del Server

Controlla anche i log di Laravel per eventuali errori:

```bash
tail -f storage/logs/laravel.log
```

Cerca errori relativi a:
- `ImageUpload`
- `uploadedImages`
- `imagesUploaded`
- Permessi file

### 9. Informazioni da Raccogliere per il Debug

Se il problema persiste, raccogli queste informazioni:

1. **Messaggi della console** (tutti i log `[ImageUpload Debug]`)
2. **Errori JavaScript** (se presenti)
3. **Richieste Network** (tab Network nella console)
4. **Versione di Livewire**: `composer show livewire/livewire`
5. **Browser e versione**
6. **Sistema operativo**

### 10. Test Rapido

Esegui questo test nella console del browser quando il modal è aperto:

```javascript
// Trova il componente
const dropZone = document.querySelector('.drop-zone');
console.log('Drop zone:', dropZone);

// Trova l'input
const input = document.querySelector('input[type="file"][wire\\:model="images"]');
console.log('Input:', input);

// Verifica Livewire
console.log('Livewire:', window.Livewire);

// Test manuale del drop
if (dropZone && input) {
    console.log('✅ Componenti trovati correttamente');
} else {
    console.log('❌ Componenti mancanti');
}
```

