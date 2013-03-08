<?php
die(var_dump($argv));

$xsd = file_get_contents($argv[1]);

$dom = new \DomDocument('1.0', 'utf-8');
$dom->loadXml($xsd);

foreach (getElements($dom, 'complexType') as $element) {
    $code = createPhpClass($element);

    $filename = sprintf('%s/src/SevenDigital/Model/%s.php', getcwd(), ucfirst($element->getAttribute('name')));

    $bytes = file_put_contents($filename, $code);

    echo sprintf("%s: %s bytes written\n", $filename, $bytes);
}

function createPhpClass(\DOMElement $dom)
{
    $classCode = <<<PHP
<?php

namespace SevenDigital\Model;
PHP;

    $classCode .= sprintf("\n\nclass %s\n", $dom->getAttribute('name'));
    $classCode .= "{\n";
    $classCode .= addProperties($dom);
    $classCode .= "\n";
    $classCode .= addMethods($dom);
    $classCode .= "}";

    return $classCode;
}

function getElements($element, $name) {
    return $element->getElementsByTagNameNS('http://www.w3.org/2001/XMLSchema', $name);
}

function addProperty($name)
{
    return sprintf("    protected $%s;\n", $name);
}

function addMethod($name, $type)
{
    $code = '';
    $code .= sprintf("    public function set%s(%s$%s)\n", ucfirst($name), strpos($type, 'xs:') === 0 ? '' : $type.' ', $name);
    $code .= "    {\n";
    $code .= sprintf("        \$this->%s = \$%s;\n", $name, $name);
    $code .= "    }\n\n";
    $code .= sprintf("    public function get%s()\n", ucfirst($name));
    $code .= "    {\n";
    $code .= sprintf("        return \$this->%s;\n", $name);
    $code .= "    }\n\n";

    return $code;
}

function addProperties($dom)
{
    $code = '';
    foreach (getElements($dom, 'attribute') as $element) {
        $code .= addProperty($element->getAttribute('name'));
    }
    foreach (getElements($dom, 'element') as $element) {
        $code .= addProperty($element->getAttribute('name'));
    }

    return $code;
}

function addMethods($dom)
{
    $code = '';
    foreach (getElements($dom, 'attribute') as $element) {
        $code .= addMethod($element->getAttribute('name'), $element->getAttribute('type'));
    }
    foreach (getElements($dom, 'element') as $element) {
        $code .= addMethod($element->getAttribute('name'), $element->getAttribute('type'));
    }

    return $code;
}
