<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\DateTimeFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use Symfony\Component\Mime\Email;
use Twig\Node\TextNode;

class CommentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Comment::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Conference Comment')
            ->setEntityLabelInPlural('Conference Comments')
            ->setSearchFields(['author','text','email'])
            ->setDefaultSort(['createAt' => 'DESC']);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('conference'));
    }

    public function configureFields(string $pageName): iterable
    {
        // return [
        //     IdField::new('id'),
        //     TextField::new('title'),
        //     TextEditorField::new('description'),
        // ];
        yield AssociationField::new('conference');
        yield TextField::new('author');
        yield EmailField::new('text');
        yield TextareaField::new('text')
            ->hideOnIndex();
        yield TextField::new('photoFilename')
            ->onlyOnIndex();
            $creteAt = DateTimeFilter::new('createAt')->setFormTypeOptions([
                'html5' =>  true,
                'years' =>  range(date('Y'),date('Y') + 5),
                'widget'    =>  'single_text',
            ]);
        if(Crud::PAGE_EDIT === $pageName) {
            yield $creteAt->setFormTypeOption('disabled',true);
        } else {
            yield $creteAt;
        }
    }

}
