/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-block-editor/#useBlockProps
 */
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, Placeholder, Spinner } from '@wordpress/components';
import { Fragment } from '@wordpress/element';
import ServerSideRender from '@wordpress/server-side-render';
import FnuggAutocomplete from './autocomplete.js';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 */
export default function Edit({ attributes, setAttributes, clientId }) {
	const blockProps = useBlockProps();

	const options = attributes.content;

	const onChangeContent = async (newContent) => {
		const minchar = 3;
		const length = newContent.length;
		if (length >= minchar) {
			const response = await fetch(
				'https://api.fnugg.no/suggest/autocomplete/?q=' + newContent
			);
			const names = await response.json();
			const resorts = names.result;
			const count = names.total;
			setAttributes({ content: resorts });
			setAttributes({ skicount: count });
		}
	};

	const selectedSki = attributes.selected_ski;

	const FnuggResponsePlaceholder = () => {
		return (
			<Placeholder>
				<Spinner />
			</Placeholder>
		);
	};
	return (
		<Fragment>
			<InspectorControls key="setting">
				<PanelBody
					title={__('Fnugg Settings', 'fnugg-resorts')}
					initialOpen={true}
				>
					<div className="fnugg-resorts-controls">
						<FnuggAutocomplete
							attributes={attributes}
							setAttributes={setAttributes}
							clientId={clientId}
							label={__('Search Resort', 'fnugg-resorts')}
							value={selectedSki ? selectedSki : undefined}
							onChange={onChangeContent}
							options={options}
						/>
					</div>
				</PanelBody>
			</InspectorControls>
			<div {...blockProps}>
				<ServerSideRender
					block="awesome-blocks/fnugg-resorts"
					attributes={attributes}
					LoadingResponsePlaceholder={FnuggResponsePlaceholder}
				/>
			</div>
		</Fragment>
	);
}