import { registerBlockType } from '@wordpress/blocks';
import sampleBlockA from './blocks/sample-block-a';
import sampleBlockB from './blocks/sample-block-b';

const blocks = [sampleBlockA, sampleBlockB];

blocks.forEach((block) => {
  console.log(block);
  registerBlockType(...block);
});
