<?php

namespace App\Http\Controllers;

use Auth;
use View;

use App\Http\Socials\Authentication;
use Illuminate\Http\Request;

use Exception;
use GuzzleHttp\Exception\RequestException;
use App\Http\Socials\Providers\Twitter;
use App\Status;

class TwitterController extends Authentication
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
		$this->middleware('twitter', ['only' => ['getIndex','postIndex','putIndex','deleteIndex']]);
		$this->provider = 'twitter';
	}

	/**
	 * Handle process request getIndex
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function getIndex(Request $request)
	{
		$data = Auth::user()->statuses()->whereProvider('twitter')->orderBy('created_at','DESC')->get();
		return view('page.twitter')->withStatuses($data);
	}

	/**
	 * Handle process request postIndex
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function postIndex(\App\Http\Requests\Status $request)
	{
		try {
			$status = new Status;
	        $status->user = Auth::user()->id;
	        $status->message = $request->message ?: null;
	        $status->link = $request->link ?: null;
	        $status->image = $request->image ?: null;
	        $status->provider = 'twitter';
	        $status->status = 'pending';
	        $status->post_in = $request->post_in;
	        $status->delete_in = $request->delete_in;
	        $status->save();

	        if (strtotime('+1 minutes') > strtotime($request->post_in)) {
	        	$this->postToTwitter($status);
	        }

	        return response()->json(['status'=>'success','message'=>'Tweet has been sent','data'=>$this->renderView($status)]);
		} catch (Exception $e) {
		    return response()->json(['status'=>'error','message'=>$e->getMessage()]);
		}
	}

	/**
	 * post to twitter
	 *
	 * @param Status $status
	 * @return void
	 */
	protected function postToTwitter(Status $status)
	{
		try {
			$twitter = new Twitter($status);
			$twitter->post();
		} catch (RequestException $e) {
		    throw new Exception($e->getMessage());
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
                $twitter = new Twitter($status);
                $twitter->delete();
            }
            catch (RequestException $e) {
            	return response()->json(['status'=>'error','message'=>$e->message()]);
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
                $twitter = new Twitter($status);
                $twitter->post();
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
