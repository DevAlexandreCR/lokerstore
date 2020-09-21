<?php


namespace App\Constants;


class Permissions
{
    //users
    public const VIEW_USERS = 'view users';
    public const EDIT_USERS = 'edit users';
    public const DELETE_USERS = 'delete users';
    public const CREATE_USERS = 'create users';

    //admins
    public const VIEW_ADMINS = 'view admins';
    public const EDIT_ADMINS = 'edit admins';
    public const DELETE_ADMINS = 'delete admins';
    public const CREATE_ADMINS = 'create admins';

    //orders
    public const VIEW_ORDERS = 'view orders';
    public const EDIT_ORDERS = 'edit orders';
    public const CREATE_ORDERS = 'create orders';
    public const DELETE_ORDERS = 'delete orders';

    //products
    public const VIEW_PRODUCTS = 'view products';
    public const EDIT_PRODUCTS = 'edit products';
    public const CREATE_PRODUCTS = 'create products';
    public const DELETE_PRODUCTS = 'delete products';

    //stocks
    public const VIEW_STOCKS = 'view stocks';
    public const EDIT_STOCKS = 'edit stocks';
    public const CREATE_STOCKS = 'create stocks';
    public const DELETE_STOCKS = 'delete stocks';

    //payments
    public const VIEW_PAYMENTS = 'view payments';
    public const EDIT_PAYMENTS = 'edit payments';
    public const CREATE_PAYMENTS = 'create payments';
    public const DELETE_PAYMENTS = 'delete payments';

    //cart
    public const VIEW_CART = 'view cart';
    public const EDIT_CART = 'edit cart';
    public const CREATE_CART = 'create cart';
    public const DELETE_CART = 'delete cart';

    //cart
    public const VIEW_ROLES = 'view roles';
    public const EDIT_ROLES = 'edit roles';
    public const CREATE_ROLES = 'create roles';
    public const DELETE_ROLES = 'delete roles';

    //permissions
    public const VIEW_PERMISSIONS = 'view permissions';
    public const EDIT_PERMISSIONS = 'edit permissions';
    public const CREATE_PERMISSIONS = 'create permissions';
    public const DELETE_PERMISSIONS = 'delete permissions';


    public static function getAllPermissions(): array
    {
        return array(
            self::VIEW_USERS,
            self::EDIT_USERS,
            self::DELETE_USERS,
            self::CREATE_USERS,
            self::VIEW_ADMINS,
            self::EDIT_ADMINS,
            self::DELETE_ADMINS,
            self::CREATE_ADMINS,
            self::VIEW_ORDERS,
            self::EDIT_ORDERS,
            self::CREATE_ORDERS,
            self::DELETE_ORDERS,
            self::VIEW_PRODUCTS,
            self::EDIT_PRODUCTS,
            self::CREATE_PRODUCTS,
            self::DELETE_PRODUCTS,
            self::VIEW_STOCKS,
            self::EDIT_STOCKS,
            self::CREATE_STOCKS,
            self::DELETE_STOCKS,
            self::VIEW_PAYMENTS,
            self::EDIT_PAYMENTS,
            self::CREATE_PAYMENTS,
            self::DELETE_PAYMENTS,
            self::VIEW_CART,
            self::EDIT_CART,
            self::DELETE_CART,
            self::VIEW_ROLES,
            self::EDIT_ROLES,
            self::CREATE_ROLES,
            self::DELETE_ROLES,
            self::VIEW_PERMISSIONS,
            self::EDIT_PERMISSIONS,
            self::CREATE_PERMISSIONS,
            self::DELETE_PERMISSIONS,
        );
    }

    public static function getEmployePermissions(): array
    {
        return array(
            self::VIEW_USERS,
            self::EDIT_USERS,
            self::CREATE_USERS,
            self::VIEW_ORDERS,
            self::EDIT_ORDERS,
            self::CREATE_ORDERS,
            self::VIEW_PRODUCTS,
            self::EDIT_PRODUCTS,
            self::CREATE_PRODUCTS,
            self::VIEW_STOCKS,
            self::EDIT_STOCKS,
            self::CREATE_STOCKS,
            self::DELETE_STOCKS,
            self::VIEW_PAYMENTS,
            self::EDIT_PAYMENTS,
            self::CREATE_PAYMENTS,
            self::VIEW_CART,
            self::EDIT_CART,
        );
    }
}
