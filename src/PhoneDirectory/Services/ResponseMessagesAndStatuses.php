<?php
namespace PhoneDirectory\Services;

class ResponseMessagesAndStatuses{
	
	// All STATUS CODES
	const MISSING_PARAMS_STATUS_CODE = 404;
	const FATAL_ERROR_STATUS_CODE = 500;
	const SUCCESS_STATUS_CODE = 200;
	const CREATE_UPDATED_SUCCESS_STATUS_CODE = 200;
	const REDIRECT_STATUS_CODE = 302;




	// ALL RESPONSE MESSAGES
	const MISSING_PARAMS_MESSSAGE = 'Missing required parameter(s): ';
	const JSON_FORMAT_WRONG_MESSAGE = 'JSON format invalid';
	const CREATED_UPDATED_ROW_MESSAGE = 'Created/Updated record successfully';
	const SOMETHING_WENT_WRONG_MESSAGE = 'Something went wrong !!!';
	const UPDATED_ROW_MESSAGE = 'Updated record successfully';
	const DELETED_ROW_MESSAGE = 'Deleted record successfully';
	const SUCCESS_OPERATION_MESSAGE = 'Successfull operation';
	const INVALID_CREDENTIALS = 'Invalid credentails';


}