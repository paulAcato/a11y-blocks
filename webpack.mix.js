const mix = require( 'laravel-mix' ),
  fs = require( 'fs' ),
  path = require( 'path' );

const ALLOWED_FILES = ['client.scss', 'client.js', 'editor.scss', '.json'];
const ALLOWED_DIRS = ['styles', 'scripts'];
const MIX_OPTIONS = {
  styles: {
    outputStyle: 'compressed',
    processCssUrls: true
  },
  outputDir: 'build'
};

/**
 * Get all files from specific directory.
 * @param {string} directory path to file from root.
 * @return {string[]}
 */
const A11y_blocks_get_files = function (directory) {
  return fs.readdirSync( directory ).filter( file => (ALLOWED_FILES.includes( path.extname( file ) ) || ALLOWED_FILES.includes( file )) ? fs.statSync( `${directory}/${file}` ).isFile() : false );
};

/**
 * Get all directories from a specific directory.
 * @param {string} directory The directory to check.
 * @return {string[]}
 */
const getDirectories = function (directory) {
  return fs.readdirSync( directory ).filter( function (file) {
    return fs.statSync( path.join( directory, file ) ).isDirectory();
  } );
};

/**
 * Loop through the community block directories and block directories and build any files necessary.
 *
 * @param {string} folder name of the folder to scan.
 * @param {string} outputFolder name of the folder to output.
 * @constructor
 */
const A11y_blocks_build_assets = (folder, outputFolder = '') => {
  if (!!outputFolder) {
    Array.from( getDirectories( folder ) ).forEach( (typeDir) => buildFiles( typeDir, `${folder}/${typeDir}`, `${outputFolder}/${typeDir}` ) );
  } else {
    Array.from( getDirectories( folder ) ).forEach( (typeDir) => buildFiles( typeDir, `${folder}/${typeDir}` ) );
  }
};

/**
 * Little helper to reduce duplication.
 *
 * @param {string} typeDir The type of script directory.
 * @param {string} path The path of the input directory.
 * @param outputPath The path of the output directory.
 * @constructor
 */
const buildFiles = (typeDir, path, outputPath = '') => {
  const files = A11y_blocks_get_files( path );

  if (0 === files.length) {
    return;
  }

  files.forEach( (file) => {
    switch (typeDir) {
      case 'styles':
        if (!isEmptyDirectory( path ) && !isFileEmpty( `${path}/${file}` )) {
          mix.sass(
            `${path}/${file}`,
            outputPath
          )
            .options( MIX_OPTIONS.styles )
            // .setResourceRoot( `./assets/` );
        }
        break;
      case 'scripts':
        if (!isEmptyDirectory( path ) && !isFileEmpty( `${path}/${file}` )) {
          mix.js( `${path}/${file}`, outputPath ).vue( {version: 3} );
        }
        break;
    }
  } );
};

/**
 * Loop through the client directory and build any files necessary.
 *
 * @param {string} folder name of the folder to scan.
 * @param {string} outputFolder name of the folder to output.
 * @constructor
 */
const A11y_blocks_build = (folder, outputFolder = folder) => {
  Array.from( getDirectories( folder ) ).forEach( (blockDir) => {
    mix.copy( `${folder}/${blockDir}/block.json`, `${MIX_OPTIONS.outputDir}/blocks/${blockDir}` );

    const hasAssetsDirectories = !isEmptyDirectory( `${folder}/${blockDir}` ) && -1 !== Array.from( getDirectories( `${folder}/${blockDir}` ) ).indexOf( 'assets' );
    if (hasAssetsDirectories) {
      const directories = Array.from( getDirectories( `${folder}/${blockDir}/assets` ) ).filter( x => ALLOWED_DIRS.includes( x ) );

      if (directories.length > 0) {
        directories.forEach( (typeDir) => buildFiles( typeDir, `${folder}/${blockDir}/assets/${typeDir}`, `${outputFolder}/${blockDir}` ) );
      }
    }
  } );
};


/**
 * Checks if directory is empty.
 * @param {string} dirPath The path to the directory.
 * @return {boolean}
 */
const isEmptyDirectory = function (dirPath) {
  try {
    const files = fs.readdirSync( dirPath );
    return files.length === 0;
  } catch (err) {
    return true; // Directory does not exist or there was an error accessing it
  }
}

/**
 * Checks if file is empty.
 * @param {string} filePath The path to the file.
 * @return {boolean}
 */
const isFileEmpty = function (filePath) {
  try {
    const stats = fs.statSync( filePath );
    return stats.size === 0;
  } catch (err) {
    return true; // File does not exist or there was an error accessing it
  }
}

A11y_blocks_build( 'blocks' );


mix.setPublicPath( MIX_OPTIONS.outputDir )
  .version()
  .sourceMaps();
