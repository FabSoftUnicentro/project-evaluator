<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Project;

class CreateProjects extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:projects';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates the projects that are going to be evaluated and associate the members of each one';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $handle = fopen(base_path() . '/projects.csv', "r");
        $header = true;

        $this->info('Creating projects and associating its members...');
        while ($csvLine = fgetcsv($handle, 1000, ",")) {
            if ($header) {
                $header = false;
            } else {
                $projectName = $csvLine[0];
                $projectMembersEmailsString = $csvLine[1];

                $projectMembersEmails = explode(";", $projectMembersEmailsString);

                $project = Project::create([
                    'name' => $projectName
                ]);

                $this->info("Project: $projectName created!");

                foreach ($projectMembersEmails as $projectMemberEmail) {
                    $member = User::where('email', '=', $projectMemberEmail)->first();

                    $project->members()->attach($member->getKey());

                    $this->info("User: $member->name attached to project $project->name!");
                }
            }
        }
        $this->info('Projects and its users created');
    }
}
