import { __ } from '@wordpress/i18n';
import { RichText, useBlockProps } from '@wordpress/block-editor';
import metadata from './block.json';

const edit = ({ attributes, setAttributes }) => {
  return (
    <>
      <RichText
        {...useBlockProps()}
        tagName="p"
        value={attributes.content}
        allowedFormats={['core/bold', 'core/italic']}
        onChange={(content) => setAttributes({ content })}
        placeholder={__('Paragraph')}
      />
    </>
  );
};

const save = ({ attributes }) => {
  const blockProps = useBlockProps.save();
  return (
    <>
      <RichText.Content
        {...blockProps}
        value={attributes.content}
      ></RichText.Content>
    </>
  );
};

const attributes = {
  content: {
    type: 'string',
    source: 'html',
    selector: 'p',
  },
};

export default [metadata, { attributes, edit, save }];
