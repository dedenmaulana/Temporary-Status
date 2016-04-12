<?php

namespace App\Http\Controllers;

use Auth;
use View;

use App\Http\Socials\Authentication;
use Illuminate\Http\Request;

use Exception;
use App\Http\Socials\Providers\Facebook;
use App\Status;

class FacebookController extends Authentication
{
	/**
	 * Create a new facebook instance.
	 *
	 * @param vodi 
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth', ['except' => ['getAuth','getCallback']]);
		$this->middleware('facebook', ['only' => ['getIndex','postIndex','putIndex','deleteIndex']]);
		$this->provider = 'facebook';
		$this->scopes = ['publish_actions'];
	}

	/**
	 * Handle process request getIndex
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function getIndex(Request $request)
	{
		$data = Auth::user()->statuses()->whereProvider('facebook')->orderBy('created_at','DESC')->get();
		return view('page.facebook')->withStatuses($data);
	}

	/**
	 * Handle process request postIndex
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function postIndex(\App\Http\Requests\Status $request)
	{
		$status = new Status;
        $status->user = Auth::user()->id;
        $status->message = $request->message ?: null;
        $status->link = $request->link ?: null;
        $status->image = $request->image ?: null;
        $status->provider = 'facebook';
        $status->status = 'pending';
        $status->post_in = $request->post_in;
        $status->delete_in = $request->delete_in;
        $status->save();

        if (strtotime('+1 minutes') > strtotime($request->post_in)) {
        	try {
        		$this->postToFacebook($status);
    		} catch (Exception $e) {
			    return response()->json(['status'=>'error','message'=>$e->getMessage()]);
			}
        }
        
		return response()->json(['status'=>'success','message'=>'Post has been sent','data'=>$this->renderView($status)]);
	}

	/**
	 * post to facebook
	 *
	 * @param Status $status
	 * @return void
	 */
	protected function postToFacebook(Status $status)
	{
		try {
			$facebook = new Facebook($status);
			$facebook->post();
		} catch (RequestException $e) {
			$message = $e->getMessage();
			$res = $e->getRequest();
		    if ($e->hasResponse()) {
		        $res = json_decode($e->getResponse()->getBody());
		        $message = $res->error->message;
		    }

		    throw new Exception($message);
		}
	}

	/**
	 * Handle process request deleteIndex
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function deleteIndex(Request $request, $id)
	{
		$status = Auth::user()->statuses()->find($id);
		if ( ! is_null($status)) {

			try {
                $facebook = new Facebook($status);
                $facebook->delete();
            }
            catch (RequestException $e) {
            	return response()->json(['status'=>'error','message'=>$e->getMessage()]);
            }

			return response()->json(['status'=>'success','message'=>'Success deleting post']);
		}

		return response()->json(['status'=>'error','message'=>'Status not found']);
	}

	/**
	 * Handle process request putIndex
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function putIndex(Request $request, $id)
	{
		$status = Auth::user()->statuses()->find($id);
		if ( ! is_null($status)) {

			try {
                $facebook = new Facebook($status);
                $facebook->post();
            }
            catch (RequestException $e) {
            	return response()->json(['status'=>'error','message'=>$e->message()]);
            }
			
			return response()->json(['status'=>'success','message'=>'Success postig status']);
		}

		return response()->json(['status'=>'error','message'=>'Status not found']);
	}

	/**
	 * Handle process request getLogout
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function getLogout(Request $request)
	{
	    Auth::logout();
	    return redirect('/');
	}

	/**
	 * render view
	 *
	 * @param param type $param
	 * @return data type
	 */
	protected function renderView(Status $status)
	{
		return View::make('page.status')->withStatus($status)->render();
	}
}
