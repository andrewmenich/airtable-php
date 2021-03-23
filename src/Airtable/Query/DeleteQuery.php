<?php

declare(strict_types=1);

namespace Zadorin\Airtable\Query;

use Zadorin\Airtable\Errors;
use Zadorin\Airtable\Record;
use Zadorin\Airtable\Recordset;

class DeleteQuery extends AbstractQuery
{
    protected array $records = [];

    public function delete(Record ...$records): self
    {
        $this->records = $records;
        return $this;
    }

    public function execute(): Recordset
    {
        if (count($this->records) <= 0) {
            throw new Errors\RecordsNotSpecified('At least one record must be specified');
        }

        $data = ['records' => []];
        foreach ($this->records as $record) {
            $data['records'][] = $record->getId();
        }

        //$converter = fn($data) => http_build_query($data);
        //$headers = ['Content-Type' => 'application/x-www-form-urlencoded'];

        return $this->client
            ->call('DELETE', '?' . http_build_query($data));
    }
}