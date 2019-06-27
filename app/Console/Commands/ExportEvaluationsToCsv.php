<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Project;
use League\Csv\Writer;

class ExportEvaluationsToCsv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:evaluations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export the evaluations to csv format';

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
        //load the CSV document from a string
        $csv = Writer::createFromPath(base_path() . DIRECTORY_SEPARATOR . "evaluations.csv", "w");

        $projects = Project::orderedByEvaluationAverage();

        /** Project $project */
        foreach ($projects as $project) {
            $row = ["Avaliações ($project->name)"];
            $csv->insertOne($row);

            $evaluations = $project->evaluations;

            /** Evaluations $evaluation */
            $row = ["Avaliador", "Nota", "Comentário"];
            $csv->insertOne($row);
            foreach ($evaluations as $evaluation) {
                $row = [$evaluation->user->name, $evaluation->value, $evaluation->comment];
                $csv->insertOne($row);
            }

            $csv->insertOne([]);
        }
    }
}
