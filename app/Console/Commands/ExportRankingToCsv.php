<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Project;
use League\Csv\Writer;

class ExportRankingToCsv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:ranking';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export the ranking to csv format';

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
        $csv = Writer::createFromPath(base_path() . DIRECTORY_SEPARATOR . "ranking.csv", "w");

        $header = [
            'Projeto',
            'Integrantes',
            'Nota Média (Ponderada)',
            'Nota Média (Alunos/Outros)',
            'Nota Média (Professores)',
            'Número de Avaliações (Total)',
            'Número de Avaliações (Alunos/Outros)',
            'Número de Avaliações (Professores)'
        ];

        $csv->insertOne($header);

        $projects = Project::orderedByEvaluationAverage();

        /** Project $project */
        foreach ($projects as $project) {
            $row = [
                $project->name,
                $this->formatMembers($project->members),
                $project->evaluationAverage,
                round($project->studentEvaluationAverage, 2),
                round($project->teacherEvaluationAverage, 2),
                $project->evaluationCount,
                $project->studentEvaluationCount,
                $project->teacherEvaluationCount,
            ];

            $csv->insertOne($row);
        }
    }

    private function formatMembers($members)
    {
        $names = [];

        foreach ($members as $member) {
            $names[] = $member->name;
        }

        return implode(", ", $names);
    }
}
