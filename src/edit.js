import {
  TextControl,
  Flex,
  FlexBlock,
  FlexItem,
  Button,
  Icon,
  PanelBody,
  PanelRow,
  ColorPicker,
} from '@wordpress/components';
import {
  InspectorControls,
  BlockControls,
  AlignmentToolbar,
} from '@wordpress/block-editor';

/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps } from '@wordpress/block-editor';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @param {Object}   props               Properties passed to the function.
 * @param {Object}   props.attributes    Available block attributes.
 * @param {Function} props.setAttributes Function that updates individual attributes.
 *
 * @return {Element} Element to render.
 */
export default function Edit(props) {
  const blockProps = useBlockProps();

  function updateQuestion(value) {
    props.setAttributes({ question: value });
  }

  function deleteAnswer(indexToDelete) {
    const newAnswers = props.attributes.answers.filter((item, index) => {
      return index != indexToDelete;
    });
    props.setAttributes({ answers: newAnswers });

    if (indexToDelete == props.attributes.correctAnswer) {
      props.setAttributes({ correctAnswer: undefined });
    }
  }

  function markAsCorrect(index) {
    props.setAttributes({ correctAnswer: index });
  }

  return (
    <div {...blockProps}>
      <div
        className='paying-attention-edit-block'
        style={{ backgroundColor: props.attributes.bgColor }}
      >
        <BlockControls>
          <AlignmentToolbar
            value={props.attributes.textAlignment}
            onChange={(e) => {
              props.setAttributes({ textAlignment: e });
            }}
          />
        </BlockControls>
        <InspectorControls>
          <PanelBody title='Background Color' initialOpen={true}>
            <PanelRow>
              <ColorPicker
                color={props.attributes.bgColor}
                onChangeComplete={(e) =>
                  props.setAttributes({ bgColor: e.hex })
                }
              />
            </PanelRow>
          </PanelBody>
        </InspectorControls>
        <TextControl
          label='Question:'
          style={{ fontSize: '20px' }}
          value={props.attributes.question}
          onChange={updateQuestion}
        />
        <p style={{ fontSize: '13px', margin: '20px 0 8px 0' }}>Answers: </p>
        {props.attributes.answers.map((answer, index) => {
          return (
            <Flex>
              <FlexBlock>
                <TextControl
                  value={answer}
                  onChange={(newVal) => {
                    // Doing proper React update here
                    const newAnswers = props.attributes.answers.concat([]);
                    newAnswers[index] = newVal;
                    props.setAttributes({ answers: newAnswers });
                  }}
                  autoFocus={answer == undefined}
                />
              </FlexBlock>
              <FlexItem>
                <Button
                  onClick={() => {
                    markAsCorrect(index);
                  }}
                >
                  <Icon
                    icon={
                      props.attributes.correctAnswer == index
                        ? 'star-filled'
                        : 'star-empty'
                    }
                    className='mark-as-correct'
                  />
                </Button>
              </FlexItem>
              <FlexItem>
                <Button
                  className='attention-delete'
                  isLink
                  onClick={() => deleteAnswer(index)}
                >
                  Delete
                </Button>
              </FlexItem>
            </Flex>
          );
        })}
        <Button
          isPrimary
          onClick={() => {
            props.setAttributes({
              answers: props.attributes.answers.concat([undefined]),
            });
          }}
        >
          Add Another Answer
        </Button>
      </div>
    </div>
  );
}
