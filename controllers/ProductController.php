<?php
class ProductController{
    public function NombreDePagesPagination()
    {
        if(isset($_GET['id']))
        {
            $data=array('id'=>$_GET['id']);
            $nombreDePages=Product::NombreDePagesPagination($data);
            for($i=0;$i<$nombreDePages;$i++)
            {
                echo "<li class='page-item'>";
                $NumP=$i+1;
                $id_category=$_GET['id'];
                echo "<a class='page-link' href='http://localhost/electromaroc/category/$id_category/$NumP'>";
                echo $i+1;
                echo "</a>";
                echo "</li>";
            }
        }
    }

    public function afficheProduitMasquer()
    {
        $products=Product::afficheProduitMasquer();
        return $products;
    }

    public function totalProduct(){return Product::totalProduct(); }
    public function totalProductMasquer(){return Product::totalProductMasquer(); }
    public function masquerProduct()
    {
        if(isset($_GET['id']))
        {
            $data = array(
                'id' =>$_GET['id'],
            );
            $result = Product::masquer($data);
            header("location:http://localhost/electromaroc/afficheproduitadmin");
            if($result === 'ok')
            {   
            }else
            {
                echo $result;
            }
        }
    }

    public function deleteProduct(){
        if(isset($_GET['id']))
        {
            $data['id']=$_GET['id'];
            $result = Product::delete($data);
            if($result === 'ok')
            {
               header("location:http://localhost/electromaroc/afficheproduitadmin");
                
            } 
        }  
    }
   
    public function updateProduct()
    {
        if(isset($_POST['update']))
        {
            if(empty($_FILES["image"]["name"]))
            {
                $product = new ProductController();
                $productWithId=$product->getOneProduct();
                $image_product=$productWithId->photo;
            }else
            {
                $image_product=file_get_contents($_FILES["image"]["tmp_name"]);    
            }
            
            $data = array(
                'id' =>$_GET['id'],
                'reference' => $_POST['reference'],
                'libelle' => $_POST['libelle'],
                'code_barre' => $_POST['code_barre'],
                'prix_achat' => $_POST['prix_achat'],
                'prix_final' => $_POST['prix_final'],
                'prix_offre' => $_POST['prix_offre'],
                'description' => $_POST['description'],
                'categorie' => $_POST['categorie'],
               'image'=> $image_product ,
               
            );
            $result = Product::update($data);
            header("location:http://localhost/electromaroc/product/".$_GET['id']);
            if($result === 'ok')
            {
                
            }else
            {
                echo $result;
            }
        }
    }
    public function getOneProduct()
    {
        if(isset($_GET['id']))
        {
            $data = array(
                'id' =>$_GET['id']
            );
        }
        $product = Product::getProduct($data);
        return $product;
    }
    public function filter()
    {
        if(isset($_POST['category']) && isset($_POST['prixmoins']))
        {
            $data = array('category'=>$_POST['category']);
            $products=Product::CategoryPrixMoins($data);
            return $products;
        }elseif(isset($_POST['category']) && isset($_POST['prixplus']))
        {
            $data = array('category'=>$_POST['category']);
            $products=Product::CategoryPrixPlus($data);
            return $products;
        }
    }
    public function findProducts()
    {
        if(isset($_POST['search']) and !empty($_POST['search']))
        {
            $data = array('search'=>$_POST['search']);
            $products=Product::searchProduct($data);
        return $products;
        }else{
            header('location:http://localhost/electromaroc/index');
        }
        
    }
    public function getAllProducts()
    {
        $products=product::getAll();
        return $products;
    }
    public function add()
    {
        if(isset($_POST['submit']))
        {
            if(!empty($_FILES['photo']['tmp_name']))
            {
                $photo=file_get_contents($_FILES['photo']['tmp_name']);
                $data=array(
                    'reference'=>$_POST['reference'],
                    'libelle'=>$_POST['libelle'],
                    'code_barre'=>$_POST['code_barre'],
                    'prix_achat'=>$_POST['prix_achat'],
                    'prix_final'=>$_POST['prix_final'],
                    'prix_offre'=>$_POST['prix_offre'],
                    'description'=>$_POST['description'],
                    'categorie'=>$_POST['categorie'],
                    'photo'=>$photo,
                    'masquer'=>0
                );
                $result = Product::add($data);
                if($result=='ok')
                {
                    header('location:index');
                }else
                {
                    echo $result;
                }
            }
        }
    }
}
?>