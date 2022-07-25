<?php

namespace Liloi\Dumper;

use Liloi\Dumper\Atom;

/**
 * Meta class.
 * @package Liloi\Dumper
 */
class Meta
{
    /**
     * Gets meta atoms list.
     *
     * @return array List of meta atoms.
     */
    public static function getList(): array
    {

        $dirMeta = __DIR__ . '/../Meta';
        $fnsAtoms = self::getDirContents($dirMeta);

        $list = [];

        foreach ($fnsAtoms as $fn)
        {
            $data = json_decode(file_get_contents($fn), true);

            foreach($data as $datum)
            {
                $list[] = new Atom($datum);
            }
        }

        return $list;
    }

    /**
     * Gets atom JSON list.
     *
     * @param string $dir Find at directory.
     * @return array Atom JSON list.
     */
    private static function getDirContents(string $dir): array
    {
        $list = [];
        $files = scandir($dir);

        foreach($files as $value)
        {
            if(in_array($value, ['.', '..']))
            {
                continue;
            }

            $filename = $dir . DIRECTORY_SEPARATOR . $value;

            if(!is_dir($filename))
            {
                $ext = pathinfo($filename, PATHINFO_EXTENSION);

                if(in_array($ext, ['json', 'atom']))
                {
                    $list[] = $filename;
                }

                continue;
            }

            $list = array_merge($list, self::getDirContents($filename));
        }

        return $list;
    }

    /**
     * Dump all atoms.
     * @todo Add test (foreign systems request check; ).
     */
    public static function dump(): void
    {
        $dirDumper = Config::getDumperDirectory();
        $atoms = self::getList();

        /** @var Atom $atom */
        foreach ($atoms as $atom)
        {
            $local = $dirDumper . $atom->getLocal();
            $dirLocal = dirname($local);
            $global = $atom->getGlobal();

            if(!is_dir($dirLocal))
            {
                mkdir($dirLocal, 0777, true);
            }

            $request = sprintf(
                'wget "%s" -O "%s"',
                $global,
                $local
            );

            shell_exec($request);
        }
    }
}