<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $video->getId() ?></td>
    </tr>
    <tr>
      <th>Name:</th>
      <td><?php echo $video->getName() ?></td>
    </tr>
    <tr>
      <th>Width:</th>
      <td><?php echo $video->getWidth() ?></td>
    </tr>
    <tr>
      <th>Height:</th>
      <td><?php echo $video->getHeight() ?></td>
    </tr>
    <tr>
      <th>Video bitrate:</th>
      <td><?php echo $video->getVideoBitrate() ?></td>
    </tr>
    <tr>
      <th>Audio bitrate:</th>
      <td><?php echo $video->getAudioBitrate() ?></td>
    </tr>
    <tr>
      <th>User:</th>
      <td><?php echo $video->getUserId() ?></td>
    </tr>
    <tr>
      <th>Filename:</th>
      <td><?php echo $video->getFilename() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $video->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $video->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('video/edit?id='.$video->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('video/index') ?>">List</a>
