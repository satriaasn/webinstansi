<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Contact;
use App\Models\User;
use Session;
use DB;
use Mail;

use Yajra\Datatables\Datatables;
use Vinkla\Hashids\Facades\Hashids;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
		if(Auth::user()->can('contact')) {
			return view('backend.contact.datatable');
		} else {
			return redirect('dashboard');
		}
    }

	/**
	 * Displays datatables front end view
	 *
	 * @return \Illuminate\View\View
	 */
    public function getIndex()
	{
		if(Auth::user()->can('contact') || Auth::user()->can('users')) {
			return view('backend.contact.datatable');
		} else {
			return redirect('dashboard');
		}
	}

	/**
	 * Process datatables ajax request.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function anyData()
	{
		$contacts = Contact::leftJoin('users', 'users.id', '=', 'contacts.created_by')
			->select('contacts.*', 'users.id as uid', 'users.name as uname');
		return Datatables::of($contacts)
			->addColumn('check', function ($contact) {
				$check = '<div style="text-align:center;">
					<input type="checkbox" id="titleCheckdel" />
					<input type="hidden" class="deldata" name="id[]" value="'.Hashids::encode($contact->id).'" disabled />
				</div>';
				return $check;
			})
			->addColumn('read', function ($contact) {
				return $contact->read == 'Y' ? 'Read' : 'Unread';
			})
			->editColumn('subject', function ($row) {
                return mb_convert_encoding($row->subject, "UTF-8", "auto");
            })
			->editColumn('message', function ($row) {
                return mb_convert_encoding($row->message, "UTF-8", "auto");
            })
            ->addColumn('action', function ($contact) {
				$btn = '<div style="text-align:center;">';
				$btn .= '<a href="'.url('dashboard/contact/'.Hashids::encode($contact->id).'').'" class="btn btn-secondary btn-sm" title="View"><span class="fa fa-eye" aria-hidden="true"/></a> ';
				$btn .= '<a href="'.url('dashboard/contact/reply/'.Hashids::encode($contact->id).'').'" class="btn btn-warning btn-sm" title="Reply"><span class="fa fa-reply" aria-hidden="true"/></a> ';
				// $btn .= '<a href="'.url('dashboard/contact/'.Hashids::encode($contact->id).'/edit').'" class="btn btn-primary btn-sm" title="Edit"><span class="fa fa-pencil" aria-hidden="true"/></a> ';
				$btn .= '<a href="'.url('dashboard/contact/'.Hashids::encode($contact->id).'').'" class="btn btn-danger btn-sm" data-delete="" title="Delete"><span class="fa fa-trash" aria-hidden="true"></span></a>';
				$btn .= '</div>';
				return $btn;
            })
			->addColumn('control', function ($contact) {
				$check = '<div style="text-align:center;"><a href="javascript:void(0);" class="btn btn-secondary btn-sm"><span class="fa fa-plus" /></a></div>';
				return $check;
			})
			->escapeColumns([])
			->make(true);
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
		if(Auth::user()->can('contact')) {
			return view('backend.contact.create');
		} else {
			return redirect('dashboard');
		}
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
		if(Auth::user()->can('contact')) {
			$this->validate($request, [
				'name' => 'required',
				'email' => 'required',
				'subject' => 'required',
				'message' => 'required',
                'captcha' => 'required|captcha'
			]);
			$request->request->add([
				'read' => 'N',
				'created_by' => Auth::User()->id,
				'updated_by' => Auth::User()->id
			]);
			$requestData = $request->all();

			Contact::create($requestData);

			Session::flash('flash_message', 'Contact added!');

			return redirect('dashboard/contact/table');
		} else {
			return redirect('dashboard');
		}
    }

	public function submit(Request $request)
    {
		$this->validate($request,  [
			'name' => 'required',
			'email' => 'required',
			'subject' => 'required',
			'message' => 'required',
            'captcha' => 'required|captcha'
		]);
		$request->request->add([
			'read' => 'N',
			'created_by' => '1',
			'updated_by' => '1'
		]);
		$requestData = $request->all();

		Contact::create($requestData);

		Session::flash('flash_message', 'Berhasil mengirimkan Pesan!');

		return redirect('contact');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
		if(Auth::user()->can('contact')) {
			$ids = Hashids::decode($id);
			$contact = Contact::findOrFail($ids[0]);
			$contact->update([
				'read' => 'Y',
				'updated_by' => Auth::User()->id
			]);

			return view('backend.contact.show', compact('contact'));
		} else {
			return redirect('dashboard');
		}
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
		if(Auth::user()->can('contact')) {
			$ids = Hashids::decode($id);
			$contact = Contact::findOrFail($ids[0]);

			return view('backend.contact.edit', compact('contact'));
		} else {
			return redirect('dashboard');
		}
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
		if(Auth::user()->can('contact')) {
			$ids = Hashids::decode($id);
			$this->validate($request, [
				'name' => 'required',
				'email' => 'required',
				'subject' => 'required',
				'message' => 'required'
			]);
			$request->request->add([
				'updated_by' => Auth::User()->id
			]);
			$requestData = $request->all();

			$contact = Contact::findOrFail($ids[0]);
			$contact->update($requestData);

			Session::flash('flash_message', 'Contact updated!');

			return redirect('dashboard/contact/table');
		} else {
			return redirect('dashboard');
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
		if(Auth::user()->can('contact')) {
			$ids = Hashids::decode($id);
			Contact::destroy($ids[0]);

			Session::flash('flash_message', 'Contact deleted!');

			return redirect('dashboard/contact/table');
		} else {
			return redirect('dashboard');
		}
    }

	/**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function deleteAll(Request $request)
    {
		if(Auth::user()->can('contact')) {
			if ($request->has('id')) {
				$ids = $request->id;
				foreach($ids as $id){
					$idd = Hashids::decode($id);
					Contact::destroy($idd[0]);
				}
				Session::flash('flash_message', 'Contact deleted!');
			} else {
				Session::flash('flash_message', 'No data deleted!');
			}

			return redirect('dashboard/contact/table');
		} else {
			return redirect('dashboard');
		}
    }

	public function reply($id)
    {
		if(Auth::user()->can('contact')) {
			$ids = Hashids::decode($id);
			$contact = Contact::findOrFail($ids[0]);

			return view('backend.contact.reply', compact('contact'));
		} else {
			return redirect('dashboard');
		}
    }

	public function actreply($id, Request $request)
    {
		if(Auth::user()->can('contact')) {
			$ids = Hashids::decode($id);
			$this->validate($request, [
				'reply' => 'required'
			]);
			$data = array(
				'read' => 'Y',
				'update_user' => Auth::User()->id
			);

			$contact = Contact::findOrFail($ids[0]);
			$contact->update($data);

			Mail::send('emails.reply', compact('contact', 'request'), function($message) use ($contact, $request){
				$message->to($contact->email);
				$message->subject(config('app.name').' - Reply Contact');
			});

			if (Mail::failures()) {
				Session::flash('flash_message', 'Contact reply failed!');
				return redirect('dashboard/contact/table');
			} else {
				Session::flash('flash_message', 'Contact reply success!');
				return redirect('dashboard/contact/table');
			}
		} else {
			return redirect('dashboard');
		}
    }
}
