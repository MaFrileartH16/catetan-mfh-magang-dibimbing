<?php declare(strict_types=1);

    namespace App\GraphQL\Resolvers;

    use App\Models\Note as NoteModel;
    use Illuminate\Support\Collection;
    use InvalidArgumentException;

    final readonly class NoteResolver
    {
        /**
         * Get all notes.
         *
         * @param array<string, mixed> $args
         * @return Collection<NoteModel>
         */
        public function getNotes(array $args): Collection
        {
            return NoteModel::all();
        }

        /**
         * Get a single note by ID.
         *
         * @param array{id: string} $args
         * @return NoteModel
         * @throws InvalidArgumentException if note is not found
         */
        public function getNote(array $args): NoteModel
        {
            $note = NoteModel::find($args['id']);

            if ($note === null) {
                throw new InvalidArgumentException('Note not found.');
            }

            return $note;
        }

        /**
         * Create a new note.
         *
         * @param array{title: string, body: string} $args
         * @return NoteModel
         */
        public function createNote(array $args): NoteModel
        {
            $this->validateNoteArgs($args);

            return NoteModel::create([
                'title' => $args['title'],
                'body' => $args['body'],
            ]);
        }

        /**
         * Validate note arguments.
         *
         * @param array<string, mixed> $args
         * @return void
         * @throws InvalidArgumentException if validation fails
         */
        private function validateNoteArgs(array $args): void
        {
            if (empty($args['title']) || !is_string($args['title'])) {
                throw new InvalidArgumentException('Invalid or missing title.');
            }

            if (empty($args['body']) || !is_string($args['body'])) {
                throw new InvalidArgumentException('Invalid or missing body.');
            }
        }

        /**
         * Update an existing note.
         *
         * @param array{id: string, title: string, body: string} $args
         * @return NoteModel
         * @throws InvalidArgumentException if note is not found
         */
        public function updateNote(array $args): NoteModel
        {
            $this->validateNoteArgs($args);

            $note = NoteModel::find($args['id']);

            if ($note === null) {
                throw new InvalidArgumentException('Note not found.');
            }

            $note->update([
                'title' => $args['title'],
                'body' => $args['body'],
            ]);

            return $note;
        }

        /**
         * Delete a note.
         *
         * @param array{id: string} $args
         * @return NoteModel
         * @throws InvalidArgumentException if note is not found
         */
        public function deleteNote(array $args): NoteModel
        {
            $note = NoteModel::find($args['id']);

            if ($note === null) {
                throw new InvalidArgumentException('Note not found.');
            }

            $note->delete();

            return $note;
        }
    }
