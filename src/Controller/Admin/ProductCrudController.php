<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\ProductImageType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use App\Admin\Field\VichImageField;


class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield FormField::addTab('Informations générales');
        yield AssociationField::new('category')->autocomplete();
        yield Field::new('name');
        yield MoneyField::new('price')->setCurrency('EUR')->setStoredAsCents(false);
        yield TextEditorField::new('description')->hideOnIndex();

        yield FormField::addTab('Images');
        yield CollectionField::new('productImages')
                ->setEntryType(ProductImageType::class);

    }
}
