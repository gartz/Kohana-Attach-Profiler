<?php defined('SYSPATH') or die('No direct script access.');
// 
//  fleepme-server
//  
//  Created by Gabriel Giannattasio on 2011-02-26.
//  Copyright 2011 Fleep.me. All rights reserved.
// 
/**
 * A controller to call the default internal uri and append the profiler to it.
 * @author gabrielgiannattasio
 */
class AttachProfiler_Controller_Profiler extends Controller {

	protected $_profiler = FALSE;
	
	public function before()
	{
		if(! Kohana::$profiling)
		{
			// TODO Display error, page not found.
			$this->request->redirect( Request::factory( $this->request->param("route") ) );
		}
		else
		{
			$this->_profiler = (! $this->_profiler)? (bool) Request::current()->param('profiler'): FALSE;
		}
		parent::before();
	}
	
	/**
	 * Profile controller single method.
	 */
	public function action_index()
	{
		// Load the default request, to apply the profiler after all controller
		$request = Request::factory( $this->request->param("route") );
		$response = $request->execute();
		
		$this->response->body($response);
	}
	
	public function after()
	{
		parent::after();
		if( $this->_profiler )
		{
			if($this->request->is_ajax())
			{
				// TODO output profiling when is ajax request, sugest to use firephp
			}
			else
			{
				// Display profile if its enabled and request by query profile
				$profile = (Kohana::$profiling)?"<div id=\"kohana-profiler\">".View::factory('profiler/stats')."</div>":"";
				
				// Prepend to body the application profiler
				$response = str_ireplace("</body>", "$profile</body>", $this->response->body() );
				$this->response->body($response);
			}
		}
	}
	
}