# Instal·lació

```bash 
npm install @abrusca/casteachingalbert
``` 

# Usage

```javascript
import casteaching from '@abrusca/casteachingalbert'
// Obtenir llista de vídeos publicats
casteaching.videos()
// Obtenir vídeo per ID
casteaching.video.show(1)
// Crear video
casteaching.video.create({name: 'PHP 101', description: 'Bla bla bla',  url: 'https://youtube.com/...' })
// Update video
casteaching.video.update(1,{name: 'PHP 101', description: 'Bla bla bla',  url: 'https://youtube.com/...' })
// Destroy
casteaching.video.destroy(1)
```

# Author

Albert Brusca Manchón

# More info
- https://github.com/Albert-Brusca/casteaching
- https://github.com/Albert-Brusca/casteaching_package

# Creació de repositori propi

- Scoped packages -> Prefix/espai de noms, evitar conflictes de noms -> @acacha/casteaching
- Moure a un repositori a part
- Actualitzar README
- Github submodules
