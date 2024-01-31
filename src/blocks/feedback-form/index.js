import {registerBlockType} from '@wordpress/blocks';
import edit from './scripts/edit';
import save from './scripts/save';
import metadata from './block.json';

const {name} = metadata;

registerBlockType( name, {
  ...metadata,
  edit,
  save,
} );
