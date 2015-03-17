<?php
require '../lib/lib_project1.php';

redirectIfLoggedOut();

// This is a secure area!
if ( !$MEMBER_DB_MANAGER->isAdmin() )
{
    redirectIfLoggedIn();
}

if ( $_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['submitted'] )
{
    // Clean Data
    $_POST['product_name'] = clean_input( $_POST['product_name'] );
    $_POST['price'] = intval( clean_input( $_POST['price'], true ) );
    $_POST['quantity'] = intval( clean_input( $_POST['quantity'] ) );
    $_POST['onSale'] = isset( $_POST['onSale'] ) ? true : false;
    $_POST['sale'] = intval( clean_input( $_POST['sale'], true ) );
    $_POST['description'] = clean_input( $_POST['description'] );
    
    // Product Image
    $image_file = !empty( $_FILES['image']['name'] ) ? PRODUCT_IMAGE_DIR .
             basename( $_FILES['image']['name'] ) : '';
    
    $product = new ProductForm( 0, $_POST['product_name'], $_POST['description'], $_POST['price'], 
            $_POST['quantity'], $_POST['onSale'], $_POST['sale'], $image_file );
    
    $errors = array ();
    $errors = array_merge( ProductFormValidator::validateRequiredFields( $product ), 
            ProductFormValidator::validate( $product ) );
    
    // See if product is unique
    try
    {
        if ( $PRODUCT_DB_MANAGER->loadProductByProductName( $product->getName() ) )
        {
            $errors[] .= sprintf( 'Product \'%s\' already exists!', $product->getName() );
        }
    } catch ( Exception $e )
    {}

    // See if password is this admin's password
    if ( $MEMBER_DB_MANAGER->getCurrentUser()->getPassword() != sha1( $_POST['confirmPassword'] ) )
    {
        $errors[] .= 'Password does not match';
    }
    
    // See if image is an image
    if ( count( $errors ) == 0 )
    {
        if ( getimagesize( $_FILES['image']["tmp_name"] ) === false )
        {
            $errors[] .= 'File is not an image';
        } else if ( file_exists( $product->getImagePath() ) )
        { // See if image does not already exist
            $errors[] .= 'That File already exists';
        }
    }
    
    if ( count( $errors ) == 0 )
    {
        /* Move Product Picture */
        if ( !move_uploaded_file( $_FILES['image']['tmp_name'], $image_file ) )
        {
            $errors[] .= 'File could not be uploaded';
        }
    }
    
    if ( count( $errors ) == 0 )
    {
        /* Process new product */
        $PRODUCT_DB_MANAGER->createProduct( $product );
        
        header( 'Location: ../admin.php' );
        die();
    }
}

?>

<!DOCTYPE HTML>
<html lang='EN'>

<?php
echo templateHead( 'Add Product', array ( '../css/formStyle.css' ), 
        array ( '../js/lib/jquery.formatCurrency-1.4.0.min.js', '../js/FormWidget.js' ) );
?>

<body>

    <?= templateHeader( false )?>
    <div id='content'>
        <h1>Add a New Product to the Catalog!</h1>
        <form id='addProductForm' method='POST' enctype="multipart/form-data">
            <?= $feedback?>
            <?php if(count($errors)>0) {foreach ($errors as $error){printf("<p class='error'><span>%s</span></p>", $error);}} ?>
                
            <p>
                <label for='product_name'>Product:</label>
                <input id='product_name' type='text' name='product_name' placeholder='Product name'
                    <?= (isset($_POST['product_name']))? 'value="' . $_POST['product_name'] . '"':''?>
                />
            </p>
            <p>
                <label for='price'>Retail Price:</label>
                <input id='price' class='currency' type='text' name='price'
                    placeholder='Retail price'
                    <?= (isset($_POST['price']))? 'value="' . $_POST['price']/100.0 . '"':''?>
                />
            </p>
            <p>
                <label for='quantity'>Quantity:</label>
                <input id='quantity' type='number' min='1' name='quantity'
                    placeholder='Incoming inventory'
                    <?= (isset($_POST['quantity']))? 'value="' . $_POST['quantity'] . '"':''?>
                />
            </p>
            <p>
                <label for='onSale'>Product is On Sale:</label>
                <input id='onSale' type='checkbox' name='onSale' placeholder='Sale price'
                    <?= (isset($_POST['onSale']) && $_POST['onSale'])? 'checked':''?>
                />
            </p>
            <p>
                <label for='sale'>Sale Price:</label>
                <input id='sale' class='currency' type='text' name='sale' placeholder='Sale price'
                    <?= (isset($_POST['sale']))? 'value="' . $_POST['sale']/100.0 . '"':''?>
                />
            </p>
            <p>
                <label for='description'>Description:</label>
                <textarea id='description' type='text' maxlength='200' name='description'
                    placeholder='Product description'
                ><?= (isset($_POST['description']))? $_POST['description']:''?></textarea>
            </p>
            <p>
                <label for='image'>Product Image:</label>
                <input id='image' accept='image/*' type='file' name='image' />
            </p>
            <p>
                <label for='confirmPassword'>Password:</label>
                <input id='confirmPassword' type='password' name='confirmPassword'
                    placeholder='Your password'
                />
            </p>
            <div id='formButtons'>
                <p>
                    <input type='submit' value='Add Product' name='submitted' />
                    <input type='button' value='Clear'
                        onclick="$('#signupForm input[type=text], #signupForm input[type=email], #signupForm input[type=password]').val('')"
                    />
                </p>
                <p>
                    <input type='button' value='Nevermind'
                        onclick="javascript:window.location='../admin.php'"
                    />
                </p>
            </div>
        </form>

    </div>
</body>

</html>