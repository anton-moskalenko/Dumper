# Build dumper

## Algorithm:

1. Add dumper link file or files inside Meta/ directory (subdirs allowed).
1. Run build shell at console: <pre>./Build.spell</pre>
1. Place Dumper.phar to destination directory
1. Run it at console: <pre>php Dumper.phar</pre>

## Running tests

Run tests shell at console: <pre>./Tests.spell</pre>

## File syntax

<pre>
[
    {
        "title": "File title",
        "description": "File description",
        "type": "file",
        "global": "URL of file",
        "local": "Local output file name"
    },
    ...
]
</pre>