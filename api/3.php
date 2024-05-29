<?php

// Data JSON yang diberikan
$jsonData = '{"metaData":{"code":"200","message":"Sukses"},"response":"2gzBJpeFMWMGX5XGpP3+MRek4\/seq94Z1ifihmZfuwTvLqMDfnBsLEUZSQLtySG7yPiBOJbkx6Qp4tvV5iSoPaSkc1A8Vyg74lfZg9cQHL2vUCO2QhQLmU3ZjMP0T7biglpDeguELk8wHN8\/3B8xzi0qNeZBJlY7JOHi0VsCzICQMVjIqlmkSa6Jl4nvvTeRbwCkTeH8mf0Mm1gOCss8+Q8\/663ssiFrh+QlfZIjX\/Lac\/bcRf6DNyR53ykc6C+hCC+hG+d5twGnA8hNxE2R187Z5\/iho4A22xoLO+0Yr1EXPu9VXkQvnM27ZNYEVX5Ll8eED70SOGoiHytdwedbPB0Gun99Jhod3XAs\/RJS6JHZpbxHJ+EfG2ghNvSgy734gLswbi5obb5yqNf5HkpJZJjVr8Or05zf1GF+D3RvqbeAKPkPCW8iW1feRHp500QBIFLfJVrZb4XBujA4sR9kmMH30\/ZZHLa9jFACO53jtBv2+RIRgUjqkE+1DJtTZHrKDbiTABAyCJ8BG3RkS4VkyOnb8Os9LV0FmXfkqX8V6ABIdPDcP\/yMRY3sQJzOf22gRX+L958H8J0++FNlJ4uDfCxq+ObF6BOQZiQlcNG70Mlf8mILf8qU0T3hZ8F3MMPtzm7nXGzuyp7CpVH49NueLieEWjf5nt5LRwQMr0rQWFxctzYo5eWt1uNok6ii6relepnOLE+I7S73irIX+HfIN2YDwvd0iZqzQi0lxnCOzab+Pk4oLdLX\/p\/BP1Ick3Nb1vClyHeSXS4f+vD0THO0MPyPkGjV5ACdF\/Z5lmeKQYHdzPBBxxy7ZMZNxmn1y0E\/SnWYF0IzKYfsYcdZ5kZC5NG8tIvgM96tJ95BgPR1uIOcvLBTulz\/JnXZFRvnAHD9DCUsnVQcVBeefCqsrxz3pI5EAGoezxbaXBlrTuU9n1uvGcZFWHpZ0eH47l9acns12qbm3Gt1C8VLua0eNlPovjOEdh4OuumJNwZC6Jgl6dwdWpqMyGs5nYOAVWMMFk0LyFQIQVyc9ebi9HrTIJC\/8V4rj7m\/vt08S2dj0QbInKn2zms4s7pop9cisxECV3YMbSzvUfrTIBG3z4SzWDqSWCM53Z4+jfb8aKXymnpzr3AT0hQNnpX\/pZOudBiksLDqU\/BBh6\/a8NHVhfuoHSyodmOyw9OS6oYAaZdM+xzdTNPQxVAkPTM+80\/GW+mHy6DrDzU4iJcAAD8bVTkhzx35VzdWergmB7cej20EKJIb\/dwg\/sWMq9DZAfpNSZqW2nKJ90zg+a0aszCWeoD0pYeoGmhGvgwOovocqW\/KwXsH9rc="}';

// Mendapatkan objek respons dari data JSON
$response = json_decode($jsonData);

// Mengakses properti 'response'
$responseData = $response->response;

// Melakukan dekripsi base64 terhadap nilai respons
$decodedResponse = base64_decode($responseData);

// Output hasil dekripsi
echo $decodedResponse;