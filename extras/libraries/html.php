<?php

function html_doctype($doctype) {
	if ($doctype === 'html_5') {
		$declaration = '<!DOCTYPE html>';
	} elseif ($doctype === 'html_4.01_s') {
		$declaration = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">';
	} elseif ($doctype === 'html_4.01_t') {
		$declaration = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
	} elseif ($doctype === 'html_4.01_f') {
		$declaration = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">';
	} elseif ($doctype === 'xhtml_1.0_s') {
		$declaration = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
	} elseif ($doctype === 'xhtml_1.0_t') {
		$declaration = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
	} elseif ($doctype === 'xhtml_1.0_f') {
		$declaration = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">';
	} elseif ($doctype === 'xhtml_1.1') {
		$declaration = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">';
	} else {
		$declaration = '';
	}

	if ($declaration !== '') {
		print $declaration . "\n";
	}
}

function html_anchor($value, $url, $name = NULL, $extra_attributes = NULL) {
	if ($name !== NULL && $extra_attributes !== NULL) {
		$hyperlink = '<a name="' . $name . '" href="' . $url . '" ' . $extra_attributes . '>' . $value . '</a>';
	} elseif ($name !== NULL && $extra_attributes === NULL) {
		$hyperlink = '<a name="' . $name . '" href="' . $url . '">' . $value . '</a>';
	} elseif ($extra_attributes !== NULL && $name === NULL) {
		$hyperlink = '<a href="' . $url . '" ' . $extra_attributes . '>' . $value . '</a>';
	} else {
		$hyperlink = '<a href="' . $url . '">' . $value . '</a>';
	}

	print $hyperlink . "\n";
}

function html_form_open($action, $method, $name = NULL, $extra_attributes = NULL) {
	if ($name !== NULL && $extra_attributes !== NULL) {
		$form_open = '<form action="' . $action . '" method="' . $method . '" name="' . $name . '" ' . $extra_attributes . '>';
	} elseif ($name !== NULL && $extra_attributes === NULL) {
		$form_open = '<form action="' . $action . '" method="' . $method . '" name="' . $name . '">';
	} elseif ($extra_attributes !== NULL && $name === NULL) {
		$form_open = '<form action="' . $action . '" method="' . $method . '" ' . $extra_attributes . '>';
	} else {
		$form_open = '<form action="' . $action . '" method="' . $method . '">';
	}

	print $form_open . "\n";
}

function html_form_close() {
	$form_close = '</form>';
	print $form_close . "\n";
}

function html_input($type, $other_attributes = NULL) {
	if ($other_attributes !== NULL) {
		$input_field = '<input type="' . $type . '" ' . $other_attributes . ' />';
	} else {
		$input_field = '<input type="' . $type . '" />';
	}

	print $input_field . "\n";
}

function html_select_list($options_array, $select_attributes = NULL) {
	if ($select_attributes !== NULL) {
		$select_open = '<select ' . $select_attributes . '>';
	} else {
		$select_open = '<select>';
	}

	$option_tag = '';
	foreach ($options_array as $value => $option) {
		$option_tag .= '<option value="' . $value . '">' . $option . '</option>' . "\n";
	}

	$select_close = '</select>';

	print $select_open . "\n";
	print $option_tag;
	print $select_close . "\n";
}

function html_select_list_with_groups($options_array, $select_attributes = NULL) {
	if ($select_attributes !== NULL) {
		$select_open = '<select ' . $select_attributes . '>';
	} else {
		$select_open = '<select>';
	}

	$option_tag = '';
	foreach ($options_array as $key => $array) {
		$option_tag .= '<optgroup label="' . $key . '">' . "\n";
		foreach ($array as $value => $option) {
			$option_tag .= '<option value="' . $value . '">' . $option . '</option>' . "\n";
		}
		$option_tag .= '</optgroup>' . "\n";
	}

	$select_close = '</select>';

	print $select_open . "\n";
	print $option_tag;
	print $select_close . "\n";
}