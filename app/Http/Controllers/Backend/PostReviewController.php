<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\PostReview;
use Session;

use Yajra\Datatables\Datatables;
use Vinkla\Hashids\Facades\Hashids;

class PostReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('admin')) {
            return view('backend.post-review.datatable');
        } else {
            return redirect('dashboard');
        }
    }

    public function getIndex()
    {
        return $this->index();
    }

    /**
     * Process datatables ajax request.
     */
    public function anyData()
    {
        $reviews = PostReview::leftJoin('posts', 'posts.id', '=', 'post_reviews.post_id')
            ->select('post_reviews.*', 'posts.title as post_title');

        return Datatables::of($reviews)
            ->addColumn('check', function ($review) {
                $check = '<div style="text-align:center;">
					<input type="checkbox" id="titleCheckdel" />
					<input type="hidden" class="deldata" name="id[]" value="' . Hashids::encode($review->id) . '" disabled />
				</div>';
                return $check;
            })
            ->addColumn('status_badge', function ($review) {
                if($review->status == 'approved') return '<span class="badge bg-success">Approved</span>';
                if($review->status == 'pending') return '<span class="badge bg-warning">Pending</span>';
                return '<span class="badge bg-danger">Spam</span>';
            })
            ->addColumn('action', function ($review) {
                $btn = '<div style="text-align:center;">';
                $btn .= '<a href="' . url('dashboard/post-review/' . Hashids::encode($review->id) . '/edit') . '" class="btn btn-primary btn-sm" title="Edit Review"><span class="fa fa-pencil" aria-hidden="true"/></a> ';
                $btn .= '<a href="' . url('dashboard/post-review/' . Hashids::encode($review->id) . '') . '" class="btn btn-danger btn-sm" data-delete="" title="Delete"><span class="fa fa-trash" aria-hidden="true"></span></a>';
                $btn .= '</div>';
                return $btn;
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('admin')) {
            $ids = Hashids::decode($id);
            $review = PostReview::with('post')->findOrFail($ids[0]);

            return view('backend.post-review.edit', compact('review'));
        } else {
            return redirect('dashboard');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        if (Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('admin')) {
            $ids = Hashids::decode($id);
            $review = PostReview::findOrFail($ids[0]);

            $requestData = $request->only('status', 'rating', 'comment');
            $review->update($requestData);

            Session::flash('flash_message', 'Review updated!');

            return redirect('dashboard/post-review/table');
        } else {
            return redirect('dashboard');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('admin')) {
            $ids = Hashids::decode($id);
            PostReview::destroy($ids[0]);

            Session::flash('flash_message', 'Review deleted!');

            return redirect('dashboard/post-review/table');
        } else {
            return redirect('dashboard');
        }
    }

    public function deleteAll(Request $request)
    {
        if (Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('admin')) {
            if ($request->has('id')) {
                $ids = $request->id;
                foreach ($ids as $id) {
                    $idd = Hashids::decode($id);
                    PostReview::destroy($idd[0]);
                }
                Session::flash('flash_message', 'Reviews deleted!');
            } else {
                Session::flash('flash_message', 'No data deleted!');
            }
            return redirect('dashboard/post-review/table');
        } else {
            return redirect('dashboard');
        }
    }
}
