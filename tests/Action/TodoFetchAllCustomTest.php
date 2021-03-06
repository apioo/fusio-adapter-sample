<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2018 Christoph Kappestein <christoph.kappestein@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Fusio\Adapter\Sample\Tests\Action;

use Fusio\Adapter\Sample\Action\TodoFetchAllCustom;
use Fusio\Adapter\Sample\Tests\DbTestCase;
use Fusio\Engine\Form\Builder;
use Fusio\Engine\Form\Container;
use PSX\Data\Record\Transformer;
use PSX\Http\Environment\HttpResponseInterface;

/**
 * TodoFetchAllCustomTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    http://fusio-project.org
 */
class TodoFetchAllCustomTest extends DbTestCase
{
    public function testHandle()
    {
        $parameters = $this->getParameters([
            'connection' => 1,
        ]);

        $action   = $this->getActionFactory()->factory(TodoFetchAllCustom::class);
        $response = $action->handle($this->getRequest(), $parameters, $this->getContext());

        $body   = json_encode(Transformer::toArray($response->getBody()), JSON_PRETTY_PRINT);
        $expect = <<<JSON
{
    "totalResults": "2",
    "entry": [
        {
            "id": "1",
            "status": "1",
            "title": "foo",
            "insertDate": "2015-02-27 19:59:15"
        },
        {
            "id": "2",
            "status": "1",
            "title": "bar",
            "insertDate": "2015-02-27 19:59:15"
        }
    ]
}
JSON;


        $this->assertInstanceOf(HttpResponseInterface::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals([], $response->getHeaders());
        $this->assertJsonStringEqualsJsonString($expect, $body, $body);
    }

    public function testGetForm()
    {
        $action  = $this->getActionFactory()->factory(TodoFetchAllCustom::class);
        $builder = new Builder();
        $factory = $this->getFormElementFactory();

        $action->configure($builder, $factory);

        $this->assertInstanceOf(Container::class, $builder->getForm());
    }
}
