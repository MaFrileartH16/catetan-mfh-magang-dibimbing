<?php declare(strict_types=1);

    namespace App\GraphQL\Mutations;

    use App\GraphQL\Resolvers\NoteResolver;
    use App\Models\Note;
    use InvalidArgumentException;

    final readonly class NoteMutation
    {
        public function __construct(private NoteResolver $noteResolver)
        {
        }

        /**
         * Create a new note.
         *
         * @param array<string, mixed> $args
         * @return Note
         */
        public function createNote(
            array $args
        ): Note
        {
            return $this->noteResolver->createNote($args);
        }

        /**
         * Update an existing note.
         *
         * @param array{id: string, title: string, body: string} $args
         * @return Note
         * @throws InvalidArgumentException if note is not found
         */
        public function updateNote(
            array $args
        ): Note
        {
            return $this->noteResolver->updateNote($args);
        }

        /**
         * Delete a note.
         *
         * @param array{id: string} $args
         * @return Note
         * @throws InvalidArgumentException if note is not found
         */
        public function deleteNote(
            array $args
        ): Note
        {
            return $this->noteResolver->deleteNote($args);
        }
    }
