<?php

namespace Utils\Rector\Tests\Rector\AttributeGenerateRuleRector\Fixture;

use Something\Entity\MyClass;

class RectorTestExample
{
    public function __construct(private readonly string $classProperty = '')
    {
    }
}
?>
    -----
<?php

namespace Utils\Rector\Tests\Rector\AttributeGenerateRuleRector\Fixture;

use Something\Entity\MyClass;

#[\AttributeAutoRegisterBundle\Attribute\Autowired]
class RectorTestExample
{
    public function __construct(private readonly string $classProperty = '')
    {
    }
}
?>
    