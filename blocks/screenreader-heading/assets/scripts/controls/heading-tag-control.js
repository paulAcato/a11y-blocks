import {__, _x} from "@wordpress/i18n";
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
 * Controller for the heading tag.
 *
 * @param {number} tag The heading tag.
 * @param {function} setAttributes the WordPress setAttrbiutes function.
 * @return {{}}
 * @constructor
 */
const HeadingTagControl = ({tag = 2, setAttributes}) => {
  return useMemo( () => {

    let icon = null;
    switch (tag) {
      case 1:
        icon = headingLevel1;
        break;
      case 2:
      default:
        icon = headingLevel2;
        break;
      case 3:
        icon = headingLevel3;
        break;
      case 4:
        icon = headingLevel4;
        break;
      case 5:
        icon = headingLevel5;
        break;
      case 6:
        icon = headingLevel6;
        break;
    }

    return (
      <ToolbarDropdownMenu
        label={_x( 'Select a heading tag', 'a11y-blocks' )}
        icon={icon}
        controls={[
          {
            label: __( 'Heading 1' ),
            icon: headingLevel1,
            isActive: tag === 1,
            onClick: () => setAttributes( {tag: 1} ),
          },
          {
            label: __( 'Heading 2' ),
            icon: headingLevel2,
            isActive: tag === 2,
            onClick: () => setAttributes( {tag: 2} ),
          },
          {
            label: __( 'Heading 3' ),
            icon: headingLevel3,
            isActive: tag === 3,
            onClick: () => setAttributes( {tag: 3} ),
          },
          {
            label: __( 'Heading 4' ),
            icon: headingLevel4,
            isActive: tag === 4,
            onClick: () => setAttributes( {tag: 4} ),
          },
          {
            label: __( 'Heading 5' ),
            icon: headingLevel5,
            isActive: tag === 5,
            onClick: () => setAttributes( {tag: 5} ),
          },
          {
            label: __( 'Heading 6' ),
            icon: headingLevel6,
            isActive: tag === 6,
            onClick: () => setAttributes( {tag: 6} ),
          },
        ]}
      />
    );
  }, [tag] );
};

export default HeadingTagControl;
