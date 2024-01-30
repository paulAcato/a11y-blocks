import {registerBlockType} from '@wordpress/blocks';
import edit from './scripts/edit';
import metadata from './block.json';

const {name} = metadata;

registerBlockType( name, {
  ...metadata,
  edit,
  save: () => null,
} );
