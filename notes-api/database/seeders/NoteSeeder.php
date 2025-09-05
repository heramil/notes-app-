<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Note;

class NoteSeeder extends Seeder
{

public function run(): void
{
    Note::updateOrCreate(
        ['title' => 'Welcome'],
        ['content' => 'This is your first note.']
    );

    Note::updateOrCreate(
        ['title' => 'Second'],
        ['content' => 'Edit or delete me.']
    );
}

}
