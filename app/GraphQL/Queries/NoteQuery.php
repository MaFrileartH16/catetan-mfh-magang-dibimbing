<?php declare(strict_types=1);

    namespace App\GraphQL\Queries;

    use App\GraphQL\Resolvers\NoteResolver;
    use App\Models\Note;
    use GraphQL\Type\Definition\ResolveInfo;
    use Illuminate\Database\Eloquent\Collection;
    use Nuwave\Lighthouse\Exceptions\ValidationException;
    use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

    final readonly class NoteQuery
    {
        public function __construct(private NoteResolver $noteResolver)
        {
        }

        /**
         * Resolve the query for all notes.
         *
         * @param null $rootValue
         * @param array<string, mixed> $args
         * @param GraphQLContext $context
         * @param ResolveInfo $resolveInfo
         * @return Collection<Note>
         */
        public function getNotes(
            $rootValue,
            array $args,
            GraphQLContext $context,
            ResolveInfo $resolveInfo
        ): Collection
        {
            return $this->noteResolver->getNotes($args);
        }

        /**
         * Resolve the query for a single note by ID.
         *
         * @param null $rootValue
         * @param array{id: string} $args
         * @param GraphQLContext $context
         * @param ResolveInfo $resolveInfo
         * @return Note
         * @throws ValidationException
         */
        public function getNote(
            $rootValue,
            array $args,
            GraphQLContext $context,
            ResolveInfo $resolveInfo
        ): Note
        {
            $note = $this->noteResolver->getNote($args);

            if (!$note) {
                throw new ValidationException('Note not found', 'NOT_FOUND');
            }

            return $note;
        }
    }
