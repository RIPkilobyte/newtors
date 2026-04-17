<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class JsonType extends AbstractType implements DataTransformerInterface
{
    // Преобразование массива/объекта из БД в JSON-строку для формы
    public function transform($value): string
    {
        if ($value === null) {
            return '';
        }
        // Превращаем массив в красиво отформатированный JSON
        return json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    // Преобразование JSON-строки из формы обратно в массив для БД
    public function reverseTransform($value): array
    {
        if (empty($value)) {
            return [];
        }

        $decoded = json_decode($value, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new TransformationFailedException('Invalid JSON format.');
        }
        return $decoded;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Назначаем этот класс как трансформер для поля
        $builder->addModelTransformer($this);
    }

    // Указываем, что в форме будет использоваться обычная textarea
    public function getParent(): string
    {
        return TextareaType::class;
    }
}
