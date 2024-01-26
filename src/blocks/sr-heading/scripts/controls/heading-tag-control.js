import {__, _x, sprintf} from "@wordpress/i18n";
import {ToolbarDropdownMenu} from "@wordpress/components";
import {useMemo} from "@wordpress/element";
import {
  headingLevel1,
  headingLevel2,
  headingLevel3,
  headingLevel4,
  headingLevel5,
  headingLevel6
} from '@wordpress/icons';

/**
 * Controller for the heading level.
 *
 * @param {number} level The heading level..
 * @param {function} setAttributes the WordPress setAttrbiutes function.
 * @return {{}}
 * @constructor
 */
const HeadingTagControl = ({level = 2, setAttributes}) => {
  const headingLevels = [null, headingLevel1, headingLevel2, headingLevel3, headingLevel4, headingLevel5, headingLevel6];

  const controls = useMemo(() => (
    [
      { label: sprintf( __( 'Heading %s' ), 1), icon: headingLevel1, level: 1 },
      { label: sprintf( __( 'Heading %s' ), 2), icon: headingLevel2, level: 2 },
      { label: sprintf( __( 'Heading %s' ), 3), icon: headingLevel3, level: 3 },
      { label: sprintf( __( 'Heading %s' ), 4), icon: headingLevel4, level: 4 },
      { label: sprintf( __( 'Heading %s' ), 5), icon: headingLevel5, level: 5 },
      { label: sprintf( __( 'Heading %s' ), 6), icon: headingLevel6, level: 6 },
    ]
  ), []);

  const activeControl = controls.find(control => control.level === level);

  return useMemo(() => (
    <ToolbarDropdownMenu
      label={_x('Select a heading level', 'jabp')}
      icon={activeControl.icon || headingLevels[2]}
      controls={controls.map( control => ({
        ...control,
        isActive: control.level === level,
        onClick: () => setAttributes( {level: control.level} ),
      }) )}
      isActive={activeControl.level !== 2}
    />
  ), [level, controls, activeControl]);
};

export default HeadingTagControl;
