/**
 * A very simple autocomplete component
 *
 * This is to replace the OOTB Gutenberg Autocomplete component because it is
 * currently broken as of v4.5.1.
 *
 * See Github issue: https://github.com/WordPress/gutenberg/issues/10542
 *
 */

// Load external dependency.
import { __ } from '@wordpress/i18n';
import { Icon } from '@wordpress/components';
import { Fragment } from '@wordpress/element';

function FnuggAutocomplete( {
  label,  
  setAttributes,
  attributes,
  value,  
  clientId,
  onChange,  
  options = [],
} ) {
					

	// Function to handle the onChange event.
	const onChangeValue = ( event ) => {
		onChange( event.target.value );
	};

	//Function to handle click on autocomplete list
	const handleClick = ( event ) => {		
		let ski_selected = event.target.getAttribute("data-name");
		setAttributes( { selected_ski: ski_selected } )
		setAttributes( { content: [] } )
	};	
	
	//Function to handle click on Icon which resets the attrs
	const handleIconClick = ( event ) => {		
		setAttributes( { selected_ski: undefined } )		
		document.getElementById(clientId).value = '';		
	};		
	
	// Function to add Icon on Input field.
	const MyIcon = () => (
		<Icon onClick={handleIconClick} icon="no-alt" />
	);	
	
	const isSkiSet = attributes.selected_ski;								
	  	
	return (	
    <Fragment>           
		  	<label className="">{ label }</label>						
      		<div className="inputwrapper">
			<input  			
			value={ value }
			id={clientId}
			placeholder = { __( 'Please enter a resort name.', 'fnugg-resorts' ) }
			onChange={ onChangeValue }
			disabled= { isSkiSet ? 'disabled' : '' }
			/>
			{ isSkiSet ? <MyIcon /> : '' }
			</div>				
			<ul tabindex='-1' className='fnugg-list-menu'>
			{ options.map( ( option, index ) =>
			  <li className='fnugg-list-item' tabindex='-1'>
				  <a onClick={handleClick} href="#" data-name={ option.name } data-path={ option.site_path } className='fnugg-list-item-label'>{ option.name }</a>
			  </li>
			) }		  
			</ul>
    </Fragment>
	);
};

export default FnuggAutocomplete;