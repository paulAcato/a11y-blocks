import {__, _x, sprintf} from "@wordpress/i18n";
import {ToolbarDropdownMenu} from "@wordpress/components";
import {useMemo} from "@wordpress/element";
import {
  check as checkIcon,
  plus as plusIcon
} from '@wordpress/icons';

/**
 * Controller for the heading level.
 *
 * @param {number} style The style variant.
 * @param {function} setAttributes the WordPress setAttrbiutes function.
 * @return {{}}
 * @constructor
 */
const StyleControl = ({style = 1, setAttributes}) => {
  const icons = [null, null, checkIcon, plusIcon];

  const controls = useMemo(() => (
    [
      { label: sprintf( __( 'Heading %s' ), 1), style: 1, icon: null },
      { label: sprintf( __( 'Heading %s' ), 2), style: 2, icon: checkIcon},
      { label: sprintf( __( 'Heading %s' ), 3), style: 3, icon: plusIcon},
    ]
  ), []);

  const activeControl = controls.find(control => control.style === style);

  return useMemo(() => (
    <ToolbarDropdownMenu
      label={_x('Select a icon style', 'jabp')}
      icon={activeControl.icon || icons[1]}
      controls={controls.map( control => ({
        ...control,
        isActive: control.style === style,
        onClick: () => setAttributes( {style: control.style} ),
      }) )}
      separator={true}
      isActive={activeControl.style > 1}
    />
  ), [style, controls, activeControl]);
};

export default StyleControl;
