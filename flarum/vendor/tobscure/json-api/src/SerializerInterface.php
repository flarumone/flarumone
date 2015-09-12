<?php

/*
 * This file is part of JSON-API.
 *
 * (c) Toby Zerner <toby.zerner@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tobscure\JsonApi;

/**
 * This is the serializer interface.
 *
 * @author Toby Zerner <toby.zerner@gmail.com>
 */
interface SerializerInterface
{
    public function collection($data);

    public function resource($data);
}
