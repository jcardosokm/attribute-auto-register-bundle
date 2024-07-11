<?php

declare(strict_types=1);

namespace Utils\Rector\Rector;

use PhpParser\Node;
use PhpParser\Node\Attribute;
use PhpParser\Node\AttributeGroup;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Class_;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see \Utils\Rector\Tests\Rector\AttributeGenerateRuleRector\AutowiredAttributeGenerateRuleTest
 */
final class AutowiredAttributeGenerateRule extends AbstractRector
{
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Add #[Autowired] attribute to classes and import the Autowired attribute', [
            new CodeSample(
                <<<'CODE_SAMPLE'
                <?php

                namespace Utils\Rector\Tests\Rector\AttributeGenerateRuleRector\Fixture;

                use Something\Entity\MyClass;

                class RectorTestExample
                {
                    public function __construct(private readonly string $classProperty = '')
                    {
                    }
                }
                CODE_SAMPLE
                ,
                <<<'CODE_SAMPLE'
                <?php

                namespace Utils\Rector\Tests\Rector\AttributeGenerateRuleRector\Fixture;

                use Something\Entity\MyClass;

                #[Autowired]
                class RectorTestExample
                {
                    public function __construct(private readonly string $classProperty = '')
                    {
                    }
                }
                CODE_SAMPLE
            ),
        ]);
    }

    public function getNodeTypes(): array
    {
        return [Class_::class];
    }

    public function refactor(Node $node): ?Node
    {
        if ($node instanceof Class_ === false) {
            return null;
        }

        foreach ($node->attrGroups as $attrGroup) {
            foreach ($attrGroup->attrs as $attr) {
                if ($this->isName($attr->name, 'Autowired') || $this->isName($attr->name, '\AttributeAutoRegisterBundle\Attribute\Autowired')) {
                    return null;
                }
            }
        }

        $attribute          = new Attribute(new Name('\AttributeAutoRegisterBundle\Attribute\Autowired'));
        $node->attrGroups[] = new AttributeGroup([$attribute]);

        return $node;
    }
}
