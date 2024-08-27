<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::with('employer')->latest()->simplePaginate(3);

        return view('jobs.index', [
            'jobs' => $jobs
        ]);
    }

    public function create()
    {
        return view('jobs.create');
    }

    public function show(Job $job)
    {
        return view('jobs.show', ['job' => $job]);
    }

    public function store()
    {
        request()->validate([
            'title' => ['required', 'min:3'],
            'salary' => ['required']
        ]);

        Job::create([
            'title' => request('title'),
            'salary' => request('salary'),
            'employer_id' => 1
        ]);

        return redirect('/jobs');
    }

    public function edit(Job $job)
    {
        return view('jobs.edit', ['job' => $job]);

    }

    public function update(Job $job)
    {
        request()->validate([
            'title' => ['required', 'min:3'],
            'salary' => ['required']
        ]);

        $job->update([
            'title' => request('title'),
            'salary' => request('salary')
        ]);

        return redirect('jobs/' . $job->id);
    }

    public function destroy(Job $job)
    {

        $job->delete();
        return redirect('/jobs');

    }


    //apiController
    public function getJobs() {
        $jobs = Job::all();

        return response()->json($jobs);
    }

    public function getJobById($id) {
        $job = Job::find($id);

        if($job) {
            return response()->json($job, 200);
        } else {
            return response()->json(['message' => 'Job Not Found!'], 404);
        }
    }

    public function deleteJobById($id) {
        $job = Job::find($id);

        if($job) {
            $job->destroy($id);
            return response()->json(['message' => 'Job Deleted']);
        }
        else {
            return response()->json(['message'=> 'Job not found'], 404);
        }
    }

    public function updateJobById($id) {
        $job = Job::find($id);
        if($job) {
            $job->update([
                'title' => request('title'),
                'salary' => request('salary')
            ]);

            return response()->json($job, 200);
        }
        else { return response()->json(['message', 'Job Not Found!'], 400);}
    }
}
