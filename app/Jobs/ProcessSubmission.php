<?php

namespace App\Jobs;

use App\Events\SubmissionSaved;
use App\Models\Submission;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\DTO\SubmissionDTO;

class ProcessSubmission implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private SubmissionDTO $submissionDTO)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $submission = new Submission;
        $submission->name = $this->submissionDTO->getName();
        $submission->email = $this->submissionDTO->getEmail();
        $submission->message = $this->submissionDTO->getMessage();
        $submission->save();

        event(new SubmissionSaved($submission));
    }
}
